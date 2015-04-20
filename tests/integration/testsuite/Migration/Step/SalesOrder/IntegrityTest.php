<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Migration\Step\SalesOrder;

/**
 * SalesOrder step run test class
 * @dbFixture sales_order
 */
class IntegrityTest extends \PHPUnit_Framework_TestCase
{
    public function testPerform()
    {
        $objectManager = \Migration\TestFramework\Helper::getInstance()->getObjectManager();
        $objectManager->get('\Migration\Config')->init(dirname(__DIR__) . '/../_files/config.xml');
        $logManager = $objectManager->create('\Migration\Logger\Manager');
        $logger = $objectManager->create('\Migration\Logger\Logger');
        $mapReader = $objectManager->create('\Migration\MapReader\MapReaderSalesOrder');
        $config = $objectManager->get('\Migration\Config');
        $initialData = $objectManager->get('\Migration\Step\SalesOrder\InitialData');
        /** @var \Migration\Logger\Manager $logManager */
        $logManager->process(\Migration\Logger\Manager::LOG_LEVEL_NONE);
        \Migration\Logger\Logger::clearMessages();

        /** @var \Migration\Step\SalesOrder\Integrity $salesOrder */
        $salesOrder = $objectManager->create(
            '\Migration\Step\SalesOrder\Integrity',
            [
                'logger' => $logger,
                'map' => $mapReader,
                'config' => $config,
                'initialData' => $initialData
            ]
        );
        ob_start();
        $salesOrder->perform();
        ob_end_clean();

        $logOutput = \Migration\Logger\Logger::getMessages();
        $this->assertFalse(isset($logOutput[\Monolog\Logger::ERROR]));
    }
}