<?php

namespace Cowell\BasicTraining\Block\Adminhtml\Sales;

class Totals extends \Magento\Framework\View\Element\Template
{
    public function initTotals()
    {
        $order = $this->getParentBlock()->getOrder();

        if ($order->getCustomTotal() > 0) {
            $this->getParentBlock()->addTotal(new \Magento\Framework\DataObject([
                'code' => 'custom_discount',
                'value' => $order->getCustomTotal(),
                'base_value' => $order->getBaseCustomTotal(),
                'label' => 'Custom Total',
            ]), 'subtotal');
        }
    }
}
