<?php

namespace Ronzhin\PaymentBlackList\Api;

interface CheckCustomerDataInBlacklistInterface
{
    /**
     * @param string $paymentName
     * @param string $phone
     * @param string $email
     * @return bool
     */
    public function isPhoneOrEmailInBlacklist(string $paymentName, string $phone, string $email): bool;
}
