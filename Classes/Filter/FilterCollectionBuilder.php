<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Filter;

use TYPO3\CMS\Core\Utility\GeneralUtility;

final class FilterCollectionBuilder
{
    /**
     * @param array $allowedPaths
     *
     * @return FolderNameFilterCollection
     */
    public function buildFilterCollection(array $allowedPaths): FolderNameFilterCollection
    {
        $collection = GeneralUtility::makeInstance(FolderNameFilterCollection::class);

        foreach ($allowedPaths as $allowedPath) {

            $path = GeneralUtility::makeInstance(FilterPath::class, $allowedPath);

            if ($collection->filterExistsForStorage($path->storageUid())) {
                $collection->getFilterForStorage($path->storageUid())->addPath($path);
            } else {
                $filter = GeneralUtility::makeInstance(FolderNameFilter::class, [$path]);
                $collection->add($filter, $path->storageUid());
            }
        }

        return $collection;
    }
}
