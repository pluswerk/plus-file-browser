<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Tests\Unit\Filter;

use Pluswerk\PlusFileBrowser\Filter\FilterPath;
use Pluswerk\PlusFileBrowser\Filter\FolderNameFilter;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Resource\Driver\DriverInterface;

final class FolderNameFilterTest extends UnitTestCase
{
    /**
     * @test
     * @dataProvider pathProvider
     *
     * @param $path
     * @param $itemName
     * @param $itemIdentifier
     * @param $parentIdentifier
     * @param $expected
     */
    public function aItemIsShownOnlyIfItIsInGivenPath($path, $itemName, $itemIdentifier, $parentIdentifier, $expected): void
    {
        /** @var DriverInterface $driverInterface */
        $driverInterface = $this->createMock(DriverInterface::class);

        $filter = new FolderNameFilter($path);

        $result = $filter->filterFolderNames($itemName, $itemIdentifier, $parentIdentifier, [], $driverInterface);

        $this->assertSame($expected, $result);
    }

    public function pathProvider(): array
    {
        return [
            [
                'path' => [new FilterPath('1:/TestPathI/')],
                'itemName' => 'TestPathI',
                'itemIdentifier' => '/TestPathI/',
                'parentIdentifier' => '/',
                'expected' => true
            ],
            [
                'path' => [new FilterPath('1:/TestPathI/')],
                'itemName' => 'TestPathII',
                'itemIdentifier' => '/TestPathII/',
                'parentIdentifier' => '/',
                'expected' => -1
            ],
            [
                'path' => [new FilterPath('1:/TestPathI/')],
                'itemName' => 'TestPathI-I',
                'itemIdentifier' => '/TestPathI/TestPathI-I/',
                'parentIdentifier' => '/TestPathI/',
                'expected' => true
            ],
            [
                'path' => [new FilterPath('1:/TestPathI/')],
                'itemName' => 'SomeFileI.ext',
                'itemIdentifier' => '/TestPathI/TestPathI-I/SomeFileI.ext',
                'parentIdentifier' => '/TestPathI/TestPathI-I/',
                'expected' => true
            ],
            [
                'path' => [new FilterPath('1:/TestPathI/')],
                'itemName' => 'SomeFileII.ext',
                'itemIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/SomeFileII.ext',
                'parentIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/',
                'expected' => true
            ],
            [
                'path' => [new FilterPath('1:/TestPathI/TestPathI-I/')],
                'itemName' => 'SomeFileII.ext',
                'itemIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/SomeFileII.ext',
                'parentIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/',
                'expected' => true
            ],
            [
                'path' => [new FilterPath('1:/TestPathI/TestPathI-II/')],
                'itemName' => 'SomeFileII.ext',
                'itemIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/SomeFileII.ext',
                'parentIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/',
                'expected' => -1
            ],
            [
                'path' => [new FilterPath('1:/TestPathII/'), new FilterPath('1:/TestPathI/TestPathI-I/')],
                'itemName' => 'SomeFileII.ext',
                'itemIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/SomeFileII.ext',
                'parentIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/',
                'expected' => true
            ],
            [
                'path' => [new FilterPath('1:/TestPathII/'), new FilterPath('1:/TestPathI/TestPathI-I/')],
                'itemName' => 'SomeFileII.ext',
                'itemIdentifier' => '/TestPathIII/TestPathI-I/TestPathI-II/SomeFileII.ext',
                'parentIdentifier' => '/TestPathIII/TestPathI-I/TestPathI-II/',
                'expected' => -1
            ]
        ];
    }

    /**
     * @test
     * @dataProvider secondPathProvider
     *
     * @param $path
     * @param $secondPath
     */
    public function aFolderIdentifierCanBeAdded($path, $itemName, $itemIdentifier, $parentIdentifier, $expected, $secondPath): void
    {
        /** @var DriverInterface $driverInterface */
        $driverInterface = $this->createMock(DriverInterface::class);

        $filter = new FolderNameFilter($path);

        $filter->addPath($secondPath);

        $result = $filter->filterFolderNames($itemName, $itemIdentifier, $parentIdentifier, [], $driverInterface);

        $this->assertSame($expected, $result);
    }

    public function secondPathProvider()
    {
        return [
            [
                'path' => [new FilterPath('1:/TestPathII/')],
                'itemName' => 'SomeFileII.ext',
                'itemIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/SomeFileII.ext',
                'parentIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/',
                'expected' => true,
                'secondPath' => new FilterPath('1:/TestPathI/TestPathI-I/')
            ],
            [
                'path' => [new FilterPath('1:/TestPathII/')],
                'itemName' => 'SomeFileII.ext',
                'itemIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/SomeFileII.ext',
                'parentIdentifier' => '/TestPathI/TestPathI-I/TestPathI-II/',
                'expected' => -1,
                'secondPath' => new FilterPath('1:/TestPathIV/TestPathI-I/')
            ]
        ];
    }
}
