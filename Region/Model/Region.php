<?php

namespace Cowell\Region\Model;


use Magento\Framework\Model\AbstractModel;

class Region extends AbstractModel
{
    public function _construct()
    {
        $this->_init(\Cowell\Region\Model\ResourceModel\Region::class);
    }
}
