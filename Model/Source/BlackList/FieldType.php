<?php

namespace Ronzhin\PaymentBlackList\Model\Source\BlackList;

use Ronzhin\PaymentBlackList\Api\Data\BlackListInterface;

class FieldType implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => BlackListInterface::TYPE_PHONE, 'label' => __('Phone')],
            ['value' => BlackListInterface::TYPE_EMAIL, 'label' => __('Email')]
        ];
    }
}
