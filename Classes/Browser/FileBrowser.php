<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Browser;

use Pluswerk\PlusFileBrowser\Configuration\Constants;
use Pluswerk\PlusFileBrowser\Configuration\TypoScriptConfiguration;
use Pluswerk\PlusFileBrowser\Filter\FilterCollectionBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Recordlist\Browser\FileBrowser as T3FileBrowser;

/**
 * This file browser extends the TYPO3 default FileBrowser to add an additional filter. This filter filters the folders,
 * which are configured in TypoScript config.tx_plusfilebrowser.tca.elementBrowser.allowedPaths.[table].[field], that only
 * these folders are shown in the file browser.
 *
 * Class FileBrowser
 * @package Pluswerk\PlusFileBrowser\Browser
 */
final class FileBrowser extends T3FileBrowser
{
    /**
     * @var FileBrowserUtility|object
     */
    private $fileBrowserUtility;

    /**
     * FileBrowser constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->fileBrowserUtility = GeneralUtility::makeInstance(FileBrowserUtility::class);
    }

    /**
     * Render the file browser.
     *
     * @return string
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function render()
    {
        // Fetch storages from be user.
        $backendUser = $this->getBackendUser();
        $storages = $backendUser->getFileStorages();

        // Fetch allowed paths from TypoScript configuration
        // (config.tx_plusfilebrowser.tca.elementBrowser.allowedPaths.[table].[field])
        $allowedPaths = GeneralUtility::makeInstance(TypoScriptConfiguration::class)->getAllowedPaths(
            $this->fileBrowserUtility->fetchTable($this->bparams),
            $this->fileBrowserUtility->fetchField($this->bparams)
        );

        // Build the filters for all storage based on the allowed paths.
        $collectionBuilder = GeneralUtility::makeInstance(FilterCollectionBuilder::class);
        $collection = $collectionBuilder->buildFilterCollection($allowedPaths);

        // Add the resulting filters to the storage from be user.
        /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
        foreach ($storages as $storage) {
            if ($collection->filterExistsForStorage($storage->getUid())) {
                $storage->addFileAndFolderNameFilter(
                    [
                        $collection->getFilterForStorage($storage->getUid()),
                        'filterFolderNames'
                    ]
                );
            }
        }

        // Render TYPO3 file browser.
        return parent::render();
    }

    /**
     * Returns the url parameters for the urls in the file browser. Needs to be overwritten to ensure always the
     * pluswerk file browser is used.
     *
     * @param array $values Array of values to include into the parameters
     * @return string[] Array of parameters which have to be added to URLs
     */
    public function getUrlParameters(array $values): array
    {
        $parentArray = parent::getUrlParameters($values);
        // Use the pluswerk file browser name for all urls in file browser.
        $parentArray['mode'] = Constants::FILE_BROWSER;

        return $parentArray;
    }
}
