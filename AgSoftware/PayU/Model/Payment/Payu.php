<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\PayU\Model\Payment;

class Payu extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYUMETHOD ="payu";
    protected $_code = self::PAYUMETHOD;
    protected $_isOffline = true;

    public function isAvailable(
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        return parent::isAvailable($quote);
    }
}

