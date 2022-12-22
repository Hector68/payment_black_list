<?php

namespace Ronzhin\PaymentBlackList\Model\ResourceModel;

class BlackList extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ronzhin_payment_blacklist', 'id');
    }
}
