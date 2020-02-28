<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Tests\Unit\Filter;

use Pluswerk\PlusFileBrowser\Filter\FilterPath;
use Pluswerk\PlusFileBrowser\Filter\InvalidFilterPathException;
use Nimut\TestingFramework\TestCase\UnitTestCase;

final class FilterPathTest extends UnitTestCase
{
    /**
     * @test
     * @dataProvider filterPathProvider
     *
     * @param $pathString
     * @param $storageUid
     */
    public function aFilterPathHoldsTheStorageUid($pathString, $storageUid): void
    {
        $filterPath = new FilterPath($pathString);
        $this->assertSame($storageUid, $filterPath->storageUid());
    }

    /**
     * @test
     * @dataProvider filterPathProvider
     *
     * @param $pathString
     * @param $storageUid
     * @param $path
     */
    public function aFilterPathHoldsTheRelativeFilePath($pathString, $storageUid, $path): void
    {
        $filterPath = new FilterPath($pathString);
        $this->assertSame($path, $filterPath->path());
    }

    public function filterPathProvider()
    {
        return [
            [
                'pathString' => '1:/this/is/my/path/',
                'storageUid' => 1,
                'path' => '/this/is/my/path/'
            ],
            [
                'pathString' => '2:/other/path/',
                'storageUid' => 2,
                'path' => '/other/path/'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider invalidFilterPathProvider
     *
     * @param $pathString
     */
    public function anExceptionIsThrownWhenPathStringDosNotHaveValidStructure($pathString): void
    {
        $this->expectException(InvalidFilterPathException::class);
        new FilterPath($pathString);
    }

    public function invalidFilterPathProvider(): array
    {
        return [
            [
                'pathString' => '/invalid/path/'
            ],
            [
                'pathString' => '1'
            ],
            [
                'pathString' => '1:'
            ],
            [
                'pathString' => ':/invalid/path/'
            ]
        ];
    }
}
