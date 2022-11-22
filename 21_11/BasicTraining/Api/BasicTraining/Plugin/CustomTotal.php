<?php

namespace Cowell\BasicTraining\Plugin;

use Magento\Checkout\Model\Cart;
use Magento\Quote\Model\Quote;

class CustomTotal
{
    public function beforeSave(Cart $subject)
    {
        $subject['quote']->setCustomTotal(5);
    }
}
