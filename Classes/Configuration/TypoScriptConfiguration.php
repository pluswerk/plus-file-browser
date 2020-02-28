<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Configuration;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;

final class TypoScriptConfiguration implements SingletonInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * ExtensionConfiguration constructor.
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager = null)
    {
        $this->objectManager = $objectManager ?? GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * Get array of all paths, which should be shown in person image field element file browser.
     *
     * @param string $table
     * @param string $field
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function getAllowedPaths(string $table, string $field): array
    {
        $conf = $this->getConfiguration();
        return array_filter(GeneralUtility::trimExplode(',', $conf['config.']['tx_kueibase.']['tca.']['elementBrowser.']['allowedPaths.'][$table . '.'][$field] ?? ''));
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    private function getConfiguration(): array
    {
        if (empty($this->config)) {
            $configurationManager = $this->objectManager->get(ConfigurationManager::class);
            $this->config = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FULL_TYPOSCRIPT, 'KueiBase');
        }
        return $this->config;
    }
}
