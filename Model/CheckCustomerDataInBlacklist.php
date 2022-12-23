<?php

namespace Ronzhin\PaymentBlackList\Model;

use Ronzhin\PaymentBlackList\Api\Data\BlackListInterface;
use Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList as BlackListResourceModel;

class CheckCustomerDataInBlacklist implements \Ronzhin\PaymentBlackList\Api\CheckCustomerDataInBlacklistInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var ResourceModel\BlackList
     */
    private $blackListResourceModel;

    /**
     * @var array
     */
    private $cacheBlackList = [];


    public function __construct(Configuration $configuration, BlackListResourceModel $blackListResourceModel)
    {

        $this->configuration = $configuration;
        $this->blackListResourceModel = $blackListResourceModel;
    }

    /**
     * @param string $paymentName
     * @param string $phone
     * @param string $email
     * @return bool
     */
    public function isPhoneOrEmailInBlacklist(string $paymentName, string $phone, string $email): bool
    {
        if (!$this->configuration->canCheckPaymentMethod($paymentName)) {
            return false;
        }

        if ($this->checkUserDataInBlackList(BlackListInterface::TYPE_EMAIL, $email)) {
            return true;
        }

        if ($this->checkUserDataInBlackList(BlackListInterface::TYPE_PHONE, $phone)) {
            return true;
        }

        return false;
    }

    /***
     * @param int $fieldType
     * @param string $value
     * @return bool
     */
    private function checkUserDataInBlackList(int $fieldType, string $value): bool
    {
        $cacheKey = sprintf('%d_%s', $fieldType, $value);
        if (isset($this->cacheBlackList[$cacheKey])) {
            return $this->cacheBlackList[$cacheKey];
        }

        $this->cacheBlackList[$cacheKey] = $this->blackListResourceModel->isRowExist($fieldType, $value);

        return $this->cacheBlackList[$cacheKey];
    }

}
