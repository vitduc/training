<?php

namespace Cowell\BasicTraining\Block\Order;

class Totals extends \Magento\Framework\View\Element\AbstractBlock
{
    public function initTotals()
    {
        $orderTotalsBlock = $this->getParentBlock();
        $order = $orderTotalsBlock->getOrder();
        if ($order->getCustomTotal() > 0) {
            $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
                'code'       => 'new_total',
                'label'      => __('Custom Total'),
                'value'      => $order->getCustomTotal(),
                'base_value' => $order->getNewTotalBaseAmount(),
            ]), 'subtotal');
        }
    }
}
