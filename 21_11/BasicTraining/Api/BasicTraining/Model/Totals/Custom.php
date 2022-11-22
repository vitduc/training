<?php

namespace Cowell\BasicTraining\Model\Totals;

use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;

class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $cart;
    protected $_priceCurrency;

    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Checkout\Model\Cart $cart
    ) {
        $this->_priceCurrency = $priceCurrency;
        $this->cart = $cart;
    }

    /**
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this|bool
     */
    public function collect(
        Quote                       $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total                       $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        $itemsCollection = $this->cart->getQuote()->getItemsCollection();
        $s = $itemsCollection->getData();
        $shipping_fee = 0;
        foreach ($s as $item) {
            $shipping_fee += $item['shipping_fee'];
        }
        $discount = $shipping_fee;
        $total->addTotalAmount($this->getCode(), -$discount);
        $total->addBaseTotalAmount($this->getCode(), -$discount);
        $quote->setDiscount($discount);
        return $this;
    }

    public function fetch(
        Quote $quote,
        Total $total
    ) {
        $itemsCollection = $this->cart->getQuote()->getItemsCollection();
        $s = $itemsCollection->getData();
        $shipping_fee = 0;
        foreach ($s as $item) {
            $shipping_fee += $item['shipping_fee'];
        }
        $discount = $shipping_fee;
        return [
            'code' => $this->getCode(),
            'title' => $this->getLabel(),
            'value' => -$discount
        ];
    }
}
