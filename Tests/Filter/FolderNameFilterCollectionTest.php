<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Tests\Unit\Filter;

use Pluswerk\PlusFileBrowser\Filter\FolderNameFilter;
use Pluswerk\PlusFileBrowser\Filter\FolderNameFilterCollection;
use Nimut\TestingFramework\TestCase\UnitTestCase;

final class FolderNameFilterCollectionTest extends UnitTestCase
{
    /**
     * @test
     * @dataProvider filterProvider
     *
     * @param $filter
     * @param $storageUid
     */
    public function aFilterCanBeAddedForAStorage($filter, $storageUid): void
    {
        $folderNameFilterCollection = new FolderNameFilterCollection();
        $folderNameFilterCollection->add($filter, $storageUid);
        $this->assertSame($filter, $folderNameFilterCollection->getFilterForStorage($storageUid));
        $this->assertTrue($folderNameFilterCollection->filterExistsForStorage($storageUid));
        $this->assertFalse($folderNameFilterCollection->filterExistsForStorage(2));
    }

    public function filterProvider(): array
    {
        return [
            [
                'filter' => new FolderNameFilter([]),
                'storageUid' => 1
            ]
        ];
    }
}
