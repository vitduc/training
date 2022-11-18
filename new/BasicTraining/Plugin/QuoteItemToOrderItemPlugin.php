<?php

namespace Cowell\BasicTraining\Plugin;

class QuoteItemToOrderItemPlugin
{
    public function aroundConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
        $additional = []
    ) {
        /** @var $orderItem \Magento\Sales\Model\Order\Item */
        $orderItem = $proceed($item, $additional);
        $orderItem->setCustomAttribute($item->getCustomAttribute());
        return $orderItem;
    }
}
