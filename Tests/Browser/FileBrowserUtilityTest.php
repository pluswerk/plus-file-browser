<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Tests\Unit\Browser;

use Pluswerk\PlusFileBrowser\Browser\FileBrowserUtility;
use Nimut\TestingFramework\TestCase\UnitTestCase;

final class FileBrowserUtilityTest extends UnitTestCase
{
    /**
     * @test
     * @dataProvider bParamsProvider
     *
     * @param $expected
     * @param $params
     */
    public function aTableIsFetchedFrombparamString($expectedTable, $params, $expectedField): void
    {
        $fileBrowserUtility = new FileBrowserUtility();
        $this->assertSame($expectedTable, $fileBrowserUtility->fetchTable($params));
    }

    /**
     * @test
     * @dataProvider bParamsProvider
     *
     * @param $expectedTable
     * @param $params
     * @param $expectedField
     */
    public function aFieldIsFetchedFrombparamsString($expectedTable, $params, $expectedField): void
    {
        $fileBrowserUtility = new FileBrowserUtility();
        $this->assertSame($expectedField, $fileBrowserUtility->fetchField($params));
    }

    public function bParamsProvider()
    {
        return [
            [
                'expectedTable' => 'tx_highereducationpackage_domain_model_person',
                'params' => '|||gif,jpg,jpeg,png,svg,pdf|data-2-tx_highereducationpackage_domain_model_person-NEW5e57de779e568738120572-image-sys_file_reference|inline.checkUniqueElement||inline.importElement',
                'expectedField' => 'image'
            ],
            [
                'expectedTable' => 'tx_someother_domain_model_thing',
                'params' => '|||gif,jpg,jpeg,png,svg,pdf|data-2-tx_someother_domain_model_thing-24-some_field-sys_file_reference|inline.checkUniqueElement||inline.importElement',
                'expectedField' => 'some_field'
            ]
        ];
    }
}
