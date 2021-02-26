<?php
namespace AgSoftware\PayU\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    private $apikey;
    private $_scopeConfig;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context);

        $this->_scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    public function dataForm(Type $var = null)
    {

        $merchantId = $this->_scopeConfig->getValue('payment/payu/merchantid', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $accountId = $this->_scopeConfig->getValue('payment/payu/accountid', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $test = $this->_scopeConfig->getValue('payment/payu/test', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $apikey = $this->_scopeConfig->getValue('payment/payu/api', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $responseUrl = 'payu/response';
        $confirmationUrl = 'payu/confirmation';
        $data = array('merchantid' => $merchantId, 'accountid' => $accountId,
            'test' => $test, 'responseurl' => $responseUrl,
            'confirmationurl' => $confirmationUrl, 'apikey'=>$apikey);
        return $data;
    }

    public function getSignature($apikey, $merchantId, $referenceCode, $amount, $currency)
    {
        return \md5("" . $apikey . "~" . $merchantId . "~" . $referenceCode . "~" . $amount . "~" . $currency);
    }

}
