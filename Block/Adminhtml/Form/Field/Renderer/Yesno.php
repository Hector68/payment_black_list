<?php

namespace Ronzhin\PaymentBlackList\Block\Adminhtml\Form\Field\Renderer;

use Magento\Framework\View\Element\Html\Select;

class Yesno extends Select
{

    /**
     * @param $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->addOption(0, 'No');
            $this->addOption(1, 'Yes');
        }

        return parent::_toHtml();
    }
}
