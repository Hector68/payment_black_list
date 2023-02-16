<?php

namespace Ronzhin\PaymentBlackList\Model\ResourceModel;

use Ronzhin\PaymentBlackList\Api\Data\BlackListInterface;

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

    /**
     * @param int $fieldType
     * @param string $value
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function isRowExist(int $fieldType, string $value): bool
    {
        $select = $this->getConnection()
            ->select()
            ->from($this->getMainTable(), 'COUNT(*)')
            ->where('field_type =?', $fieldType)
            ->where('field_value = ?', $value)
            ->where('is_active = ?', BlackListInterface::ACTIVE_VALUE)
            ->limit(1);

        return (bool)$this->getConnection()->fetchOne($select);
    }
}
