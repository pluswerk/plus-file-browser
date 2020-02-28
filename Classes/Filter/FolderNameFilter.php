<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Filter;

use TYPO3\CMS\Core\Resource\Driver\DriverInterface;

final class FolderNameFilter
{
    /**
     * @var FilterPath[]
     */
    private $allowedPaths;

    /**
     * FolderNameFilter constructor.
     *
     * @param FilterPath[] $allowedPath
     */
    public function __construct(array $allowedPath)
    {
        $this->allowedPaths = $allowedPath;
    }

    /**
     * This filter accepts only folder paths, which are set in $this->allowedPaths. So in e.g. a file browser only
     * the folders and files are shown, which matches the paths in $this->allowedPaths or which are sub folders.
     * This filter works for a storage and each storage must not have more than one of this filter!
     *
     * Example:
     *
     * paths set in $this->allowedPaths:
     *  - /some/path/
     *  - /someother/path/
     *
     * This means, that the folder itself and all sub folders and files are shown:
     *  - /some/path/**
     *  - /someother/path/**
     *
     * @param                 $itemName
     * @param                 $itemIdentifier
     * @param                 $parentIdentifier
     * @param array           $additionalInformation
     * @param DriverInterface $driverInstance
     *
     * @return bool|int
     */
    public function filterFolderNames($itemName, $itemIdentifier, $parentIdentifier, array $additionalInformation, DriverInterface $driverInstance)
    {
        if ($this->matchesIdentifier($itemIdentifier) || $this->matchesParentIdentifier($parentIdentifier)) {
            return true;
        } else {
            return -1;
        }
    }

    /**
     * @param FilterPath $path
     */
    public function addPath(FilterPath $path): void
    {
        $this->allowedPaths[] = $path;
    }

    private function matchesIdentifier(string $identifier): bool
    {
        foreach ($this->allowedPaths as $allowedPath) {
            if (preg_match('%^' . $allowedPath->path() . '$%', $identifier)) {
                return true;
            }
        }
        return false;
    }

    private function matchesParentIdentifier(string $parentIdentifier): bool
    {
        foreach ($this->allowedPaths as $allowedPath) {
            if (preg_match('%^' . $allowedPath->path() . '%', $parentIdentifier)) {
                return true;
            }
        }
        return false;
    }
}
