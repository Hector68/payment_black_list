<?php

namespace Ronzhin\PaymentBlackList\Model;

use Magento\Framework\Model\AbstractModel;

class BlackList extends AbstractModel implements \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface
{
    /** @inheritDoc */
    protected $_eventPrefix = 'ronzhin_paymentblacklist_black_list';
    /**
     * @var BlackList\Validator
     */
    private $validationModel;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList::class);
    }

    public function __construct(
        \Magento\Framework\Model\Context                        $context,
        \Magento\Framework\Registry                             $registry,
        \Ronzhin\PaymentBlackList\Model\BlackList\Validator     $validationModel,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb           $resourceCollection = null,
        array                                                   $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->validationModel = $validationModel;
    }


    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return \Zend_Validate_Interface|null
     */
    protected function _getValidationRulesBeforeSave()
    {
        return $this->validationModel;
    }

    /**
     * Get id
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get field type
     * @return int|null
     */
    public function getFieldType()
    {
        return $this->getData(self::FIELD_TYPE);
    }

    /**
     * Set field type
     * @param int $fieldType
     * @return $this
     */
    public function setFieldType($fieldType)
    {
        return $this->setData(self::FIELD_TYPE, $fieldType);
    }

    /**
     * Get field value
     * @return string|null
     */
    public function getFieldValue()
    {
        return $this->getData(self::FIELD_VALUE);
    }

    /**
     * Set field value
     * @param string $fieldValue
     * @return $this
     */
    public function setFieldValue($fieldValue)
    {
        return $this->setData(self::FIELD_VALUE, $fieldValue);
    }

    /**
     * Get is active
     * @return bool|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is active
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get created at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
