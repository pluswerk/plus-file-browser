<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Tests\Unit\Configuration;

use Pluswerk\PlusFileBrowser\Configuration\TypoScriptConfiguration;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;

final class TypoScriptConfigurationTest extends UnitTestCase
{
    /**
     * @var MockObject|ObjectManager
     */
    protected $objectManager;

    /**
     * @var MockObject|ConfigurationManager
     */
    protected $configurationManager;

    protected function setUp()
    {
        $this->objectManager = $this->createMock(ObjectManager::class);
        $this->configurationManager = $this->createMock(ConfigurationManager::class);
    }

    /**
     * @test
     * @dataProvider allowedPathsProvider
     *
     * @param $expectedPathsArray
     * @param $configuration
     */
    public function aConfiguredSetOfAllowedPathsIsReturnedInArray($expectedPathsArray, $table, $field, $configuration): void
    {
        $extConf = new TypoScriptConfiguration($this->objectManager);
        $this->objectManager->expects($this->once())
                            ->method('get')
                            ->with(ConfigurationManager::class)
                            ->willReturn($this->configurationManager);

        $this->configurationManager->expects($this->once())
                                   ->method('getConfiguration')
                                   ->with(ConfigurationManager::CONFIGURATION_TYPE_FULL_TYPOSCRIPT, 'KueiBase')
                                   ->willReturn($configuration);

        $this->assertSame($expectedPathsArray, $extConf->getAllowedPaths($table, $field));
        $this->assertSame($expectedPathsArray, $extConf->getAllowedPaths($table, $field));
    }

    public function allowedPathsProvider()
    {
        return [
            [
                'expectedPathsArray' => [
                    '1:/path/one/',
                    '2:/path/two/',
                    '2:/path/three/',
                    '3:/path/four/',
                ],
                'table' => 'tx_highereducationpackage_domain_model_person',
                'field' => 'image',
                'configuration' => [
                    'config.' => [
                        'tx_kueibase.' => [
                            'tca.' => [
                                'elementBrowser.' => [
                                    'allowedPaths.' => [
                                        'tx_highereducationpackage_domain_model_person.' => [
                                            'image' => '1:/path/one/,2:/path/two/,2:/path/three/,3:/path/four/'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
