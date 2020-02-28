<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Tests\Unit\Filter;

use Pluswerk\PlusFileBrowser\Filter\FilterCollectionBuilder;
use Pluswerk\PlusFileBrowser\Filter\FilterPath;
use Pluswerk\PlusFileBrowser\Filter\FolderNameFilter;
use Pluswerk\PlusFileBrowser\Filter\FolderNameFilterCollection;
use Nimut\TestingFramework\TestCase\UnitTestCase;

final class FilterCollectionBuilderTest extends UnitTestCase
{
    /**
     * @test
     * @dataProvider allowedPathProvider
     *
     * @param $allowedPaths
     * @param $expectedCollection
     */
    public function aCollectionIsBuiltFromAllowedPathsArray($allowedPaths, $expectedCollection): void
    {
        $collectionBuilder = new FilterCollectionBuilder();
        /** @var FolderNameFilterCollection $collection */
        $collection = $collectionBuilder->buildFilterCollection($allowedPaths);

        $this->assertEquals($collection, $expectedCollection);
    }

    public function allowedPathProvider(): array
    {
        $expectedCollectionA = new FolderNameFilterCollection();
        $filterA = new FolderNameFilter([new FilterPath('1:/path/one/')]);
        $filterA->addPath(new FilterPath('1:/path/two/'));
        $expectedCollectionA->add($filterA, 1);

        $expectedCollectionB = new FolderNameFilterCollection();
        $filterB1 = new FolderNameFilter([new FilterPath('1:/path/one/')]);
        $filterB1->addPath(new FilterPath('1:/path/two/'));
        $expectedCollectionB->add($filterB1, 1);
        $filterB2 = new FolderNameFilter([new FilterPath('2:/path/one/')]);
        $filterB2->addPath(new FilterPath('2:/path/two/'));
        $expectedCollectionB->add($filterB2, 2);

        return [
            [
                'allowedPaths' => [
                    '1:/path/one/',
                    '1:/path/two/',
                ],
                'expectedCollection' => $expectedCollectionA
            ],
            [
                'allowedPaths' => [
                    '1:/path/one/',
                    '1:/path/two/',
                    '2:/path/one/',
                    '2:/path/two/',
                ],
                'expectedCollection' => $expectedCollectionB
            ]
        ];
    }
}
