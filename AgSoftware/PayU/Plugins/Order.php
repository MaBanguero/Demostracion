<?php
namespace AgSoftware\PayU\Plugins;

class Order extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $_session,
        \Magento\Sales\Api\OrderRepositoryInterface $order
    ) {
        $this->_session = $_session;
        $this->order = $order;
        parent::__construct($context);
    }
    // public function beforeGetCategories(
    //     \Magento\Checkout\Controller\Onepage\Success $subject,
    //     $var) {
    //        return $var;
    // }
    // public function afterGetCategories(
    //     \Magento\Checkout\Controller\Onepage\Success $subject,
    //     $var) {
    //     return $var;
    // }
    public function execute()
    {

    }
    public function aroundExecute(
        \Magento\Checkout\Controller\Onepage\Success $subject,
        \Closure $procced
    ) {
        $orderId=$this->_session->getLastOrderId();
        $order= $this->order->get($orderId);
        $method=$order->getPayment()->getMethod();
        // throw new \Exception(json_encode($method));
        if($method=="payu"){
            return $this->_redirect('payu');
        }
        
        return $procced();
        
    }
}
