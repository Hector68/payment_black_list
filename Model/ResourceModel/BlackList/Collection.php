<?php

namespace Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(
            \Ronzhin\PaymentBlackList\Model\BlackList::class,
            \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList::class
        );
    }
}
