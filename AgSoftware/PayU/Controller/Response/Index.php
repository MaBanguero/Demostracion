<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace AgSoftware\PayU\Controller\Response;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Api\OrderRepositoryInterface $order
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->logger = $logger;
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
        $params = $this->getRequest()->getParams();

        $response = [];
        foreach ($params as $key => $value) {
            $response[$key] = $value;
        }
       
        $id = $params["referenceCode"];
        $order = $this->order->get($id, 'increment_id');
        $orderData=$order->getData();
        $response['amount']=$order->getGrandTotal();
        $response['name']=$order->getCustomerFirstname();
        $response['currency']=$order->getBaseCurrencyCode();
        $response['shipping_method']=$order->getShippingMethod();
        // throw new \Exception("".json_encode($order->getData()));
        if (isset($response["message"])) {
            
            if ($response["message"] == "APPROVED") {

                $order->setState('complete');
                $order->setStatus('complete');
            } elseif ($response["message"] == "PENDING") {
                $order->setState('pending');
                $order->setStatus('pending');
            }else{
                $order->setState('canceled');
                $order->setStatus('canceled');
            }
            $comment = new \Magento\Framework\Phrase('Awaiting confirmation');
            $order->addStatusHistoryComment($comment);
            $order->save();
        }
        $this->logger->info(json_encode($params));
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getLayout()->getBlock('index.response')->setData(['response' => $response]);
        return $resultPage;
    }
}
