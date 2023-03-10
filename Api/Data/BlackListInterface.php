<?php

namespace Ronzhin\PaymentBlackList\Api\Data;

interface BlackListInterface extends \Magento\Framework\DataObject\IdentityInterface
{
    public const CACHE_TAG = 'pay_b';
    public const ID = 'id';
    public const FIELD_TYPE = 'field_type';
    public const FIELD_VALUE = 'field_value';
    public const IS_ACTIVE = 'is_active';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TYPE_EMAIL = 1;
    public const TYPE_PHONE = 2;

    public const ACTIVE_VALUE = 1;
    public const INACTIVE_VALUE = 0 ;

    /**
     * Get id
     * @return int|null
     */
    public function getId();

    /**
     * Set id
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get field type
     * @return int|null
     */
    public function getFieldType();

    /**
     * Set field type
     * @param int $fieldType
     * @return $this
     */
    public function setFieldType($fieldType);

    /**
     * Get field value
     * @return string|null
     */
    public function getFieldValue();

    /**
     * Set field value
     * @param string $fieldValue
     * @return $this
     */
    public function setFieldValue($fieldValue);

    /**
     * Get is active
     * @return bool|null
     */
    public function getIsActive();

    /**
     * Set is active
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get created at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
