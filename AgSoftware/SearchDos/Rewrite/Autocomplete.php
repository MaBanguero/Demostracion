<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AgSoftware\SearchDos\Rewrite;

/**
 * Provides list of Autocomplete items
 */
class Autocomplete extends \OmniPro\Search\Rewrite\Autocomplete
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;
    /**
     * @var \Magento\Catalog\Helper\ImageFactory
     */
    private $imageFactory;
    /**
     * @var \Magento\Search\Model\Query
     */
    private $searcher;

    /**
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Search\Model\Query $searcher
     */
    

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->getParam('q', false)) {
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_url->getBaseUrl());
            return $resultRedirect;
        }
        $this->dispachEvent();
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $resultJson->setData($this->getItems());
        return $resultJson;
    }

    /**
     * @inheritdoc
     */
    public function getItems()
    {
        return parent::getItems();
    }
    public function dispachEvent(){
        
    }
}
