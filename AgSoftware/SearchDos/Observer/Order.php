<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/**
 * ElasticPayments Observer
 */
namespace AgSoftware\SearchDos\Observer;

use Magento\Framework\Event\ObserverInterface;

class Order implements ObserverInterface
{
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * Sets payment settlement values
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder()->getData();
        $this->logger->info(json_encode($order));

    }
}
