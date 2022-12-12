<?php

namespace Cowell\Region\Model\ResourceModel\Region;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'region_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Cowell\Region\Model\Region::class,
            \Cowell\Region\Model\ResourceModel\Region::class
        );
    }

    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            ['dc' => $this->getTable('directory_country')],
            'main_table.country_id = dc.country_id',
            '*'
        );
    }
}
