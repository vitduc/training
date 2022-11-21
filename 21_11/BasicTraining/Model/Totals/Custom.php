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
    protected $_priceCurrency;

    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    ) {
        $this->_priceCurrency = $priceCurrency;
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
        $discount = 5;
        $total->addTotalAmount($this->getCode(), -$discount);
        $total->addBaseTotalAmount($this->getCode(), -$discount);
        $quote->setDiscount($discount);
        return $this;
    }

    public function fetch(
        Quote $quote,
        Total $total
    ) {
        $discount = 5;
        return [
            'code' => $this->getCode(),
            'title' => $this->getLabel(),
            'value' => -$discount
        ];
    }
}
