<?php

namespace Ronzhin\PaymentBlackList\Block\Adminhtml\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Payment\Helper\Data;

class PaymentMethodMapping extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * @var \Ronzhin\PaymentBlackList\Block\Adminhtml\Form\Field\Renderer\Yesno
     */
    private $yesNoRenderer;

    /**
     * @var Data
     */
    private $paymentHelper;

    public function __construct(
        Context             $context,
        Data                $paymentHelper,
        array               $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    )
    {
        parent::__construct($context, $data, $secureRenderer);
        $this->paymentHelper = $paymentHelper;
    }


    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'payment_method',
            [
                'label' => __('Payment Method'),
            ]
        );
        $this->addColumn(
            'is_active',
            ['label' => __('Disable for blacklisted customers'), 'renderer' => $this->getYesNoAttribute()]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = 'Add';
    }

    public function getArrayRows()
    {
        $element = $this->getElement();
        $elementValue = $element->getValue();
        $newValue = [];

        foreach ($this->paymentHelper->getPaymentMethods() as $paymentKey => $paymentMethod) {
            $newValue[$paymentKey] = [
                'payment_method' => $paymentMethod['title'] ?? $paymentKey,
                'is_active' => $elementValue[$paymentKey]['is_active'] ?? 0
            ];
        }

        $element->setValue($newValue);

        return parent::getArrayRows();
    }

    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [];
        $optionExtraAttr['option_' . $this->getYesNoAttribute()->calcOptionHash($row->getData('is_active'))] =
            'selected="selected"';
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }

    /**
     * Retrieve group column renderer
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    private function getYesNoAttribute()
    {
        if ($this->yesNoRenderer) {
            return $this->yesNoRenderer;
        }

        $this->yesNoRenderer = $this->getLayout()->createBlock(
            \Ronzhin\PaymentBlackList\Block\Adminhtml\Form\Field\Renderer\Yesno::class,
            '',
            ['data' => ['is_render_to_js_template' => true]]
        );


        $this->yesNoRenderer->setClass('attributes_select admin__control-select');


        return $this->yesNoRenderer;
    }
}
