<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Filter;

use Pluswerk\PlusFileBrowser\Filter\InvalidFilterPathException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class FilterPath
{
    /**
     * @var int
     */
    private $storageUid;

    /**
     * @var string
     */
    private $path;

    /**
     * FilterPath constructor.
     *
     * A file path string must contain the storage uid and a relative path in the storage to the folder.
     * Example:
     *  1:/my/path/
     * if storage with uid 1 is 'fileadmin' -> fileadmin/my/path/
     *
     * @param string $pathString
     *
     * @throws \Pluswerk\PlusFileBrowser\Filter\InvalidFilterPathException
     */
    public function __construct(string $pathString)
    {
        if (strpos($pathString, ':') === false) {
            throw new InvalidFilterPathException('The filter path must be in format [storgageUid]:[relativePathToStorage]');
        }
        $pathArray = GeneralUtility::trimExplode(':', $pathString);
        if ($pathArray[1] === '' || $pathArray[0] === '') {
            throw new InvalidFilterPathException('The filter path must be in format [storgageUid]:[relativePathToStorage]');
        }
        $this->storageUid = (int)($pathArray[0] ?? 0);
        $this->path = (string)($pathArray[1] ?? '');
    }

    /**
     * @return int
     */
    public function storageUid(): int
    {
        return $this->storageUid;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }
}
