<?php

namespace Cowell\BasicTraining\Observer;

use Magento\Framework\Event\ObserverInterface;

class SetItemCustomAttribute implements ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();
        $quoteItem->setShippingFee($product->getData('shipping_fee'));
    }
}
