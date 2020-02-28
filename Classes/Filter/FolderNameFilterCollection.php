<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Filter;

final class FolderNameFilterCollection
{
    /**
     * @var FolderNameFilter[]
     */
    private $filters;

    /**
     * @param FolderNameFilter $filter
     * @param int              $storageUid
     */
    public function add(FolderNameFilter $filter, int $storageUid): void
    {
        $this->filters[$storageUid] = $filter;
    }

    /**
     * @param $storageUid
     *
     * @return mixed
     */
    public function getFilterForStorage($storageUid): FolderNameFilter
    {
        return $this->filters[$storageUid];
    }

    /**
     * @param int $storageUid
     *
     * @return bool
     */
    public function filterExistsForStorage(int $storageUid): bool
    {
        return isset($this->filters[$storageUid]);
    }
}
