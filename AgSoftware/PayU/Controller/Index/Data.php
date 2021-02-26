<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace AgSoftware\PayU\Controller\Index;

class Data extends \Magento\Framework\App\Action\Action
{

    protected $jsonResultFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $jsonResultFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        
        \Psr\Log\LoggerInterface $logger,
        \AgSoftware\PayU\Helper\Data $helper,
        \Magento\Checkout\Model\Session $_session,
        \Magento\Sales\Api\OrderRepositoryInterface $order
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->logger = $logger;
        $this->helper = $helper;
        
        $this->_session = $_session;
        $this->order = $order;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $orderId = $this->_session->getLastOrderId();
        
        throw new \Exception("ID:".$orderId);
        
        $order=$this->order->get($orderId);
        $this->_session->clearQuote();
        $resultPage = $this->jsonResultFactory->create()->setData($this->getData($order));
        return $resultPage;
    }

    public function getData($order)
    {
        $dataHelper = $this->helper->dataForm();
        // $order = $this->getOrder();
        $this->logger->info(json_encode($order));
        $merchantId = $dataHelper["merchantid"];
        $accountId = $dataHelper["accountid"];
        $apikey = $dataHelper["apikey"];

        $test = $dataHelper["test"];
        $confirmationUrl = $dataHelper["confirmationurl"];
        $responseUrl = $dataHelper["responseurl"];
        $description = $order->getShippingMethod();
        $referenceCode = $order->getIncrementId();
        $amount = $order->getGrandTotal();
        $amount = number_format((float) $amount, 2);
        $tax = number_format((float) $order->getTaxAmount(), 2);
        $taxReturnBase = number_format((float) $order->getBaseTaxAmount(), 2);
        $currency = $order->getGlobalCurrencyCode();
        $buyerEmail = $order->getCustomerEmail();
        // throw new \Exception("". $merchantId. " ref ". $referenceCode. " am" .$amount. "cur". $currency );
        $signature = $this->helper->getSignature($apikey, $merchantId, $referenceCode, $amount, $currency);
        return array('merchantid' => $merchantId, 'accountid' => $accountId,
            'description' => $description, 'referencecode' => $referenceCode,
            'amount' => $amount, 'tax' => $tax, 'taxreturnbase' => $taxReturnBase,
            'currency' => $currency, 'signature' => $signature, 'test' => $test,
            'responseurl' => $responseUrl, 'confirmationurl' => $confirmationUrl,
            'buyeremail' => $buyerEmail);

    }

    // public function getOrder()
    // {
    //     $orderId = $this->_session->getLastOrderId();

    //     return $this->order->get($orderId);
    // }
}
