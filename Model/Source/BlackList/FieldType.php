<?php

namespace Ronzhin\PaymentBlackList\Model\Source\BlackList;

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
            ['value' => 1, 'label' => __('Phone')],
            ['value' => 2, 'label' => __('Email')]
        ];
    }
}
