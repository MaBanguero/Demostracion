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
class observer implements ObserverInterface
{
    /**
     * Sets payment settlement values
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order\Payment $payment */
        // throw new \Exception(get_class_methods($observer));
    }
}