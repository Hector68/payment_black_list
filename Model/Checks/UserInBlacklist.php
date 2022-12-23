<?php

namespace Ronzhin\PaymentBlackList\Model\Checks;

use Magento\Payment\Model\Checks\SpecificationInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Model\Quote;
use Psr\Log\LoggerInterface;
use Ronzhin\PaymentBlackList\Api\CheckCustomerDataInBlacklistInterface;

class UserInBlacklist implements SpecificationInterface
{
    /**
     * @var CheckCustomerDataInBlacklistInterface
     */
    private $blacklistCheck;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(CheckCustomerDataInBlacklistInterface $blacklistCheck, LoggerInterface $logger)
    {
        $this->blacklistCheck = $blacklistCheck;
        $this->logger = $logger;
    }

    /**
     * Check whether payment method is applicable to quote
     *
     * @param MethodInterface $paymentMethod
     * @param \Magento\Quote\Model\Quote $quote
     * @return bool
     */
    public function isApplicable(MethodInterface $paymentMethod, Quote $quote)
    {
        try {
            $phone = $this->getPhone($quote);
            $email = $this->getEmail($quote);
            $result = !$this->blacklistCheck->isPhoneOrEmailInBlacklist($paymentMethod->getCode(), $phone, $email);
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage(), ['exception' => $exception]);
            $result = true;
        }

        return $result;
    }

    /**
     * @param Quote $quote
     * @return string
     */
    private function getPhone(Quote $quote): string
    {
        $phone = '';

        if ($quote->getShippingAddress()) {
            $phone = $quote->getShippingAddress()->getTelephone();
        }

        if (empty($phone)) {
            $phone = $quote->getBillingAddress()->getTelephone();
        }
        return $phone;
    }

    /**
     * @param Quote $quote
     * @return string
     */
    private function getEmail(Quote $quote): string
    {
        $email = $quote->getCustomerEmail();

        if (empty($email) && $quote->getShippingAddress()) {
            $email = $quote->getShippingAddress()->getEmail();
        }

        if (empty($email)) {
            $email = $quote->getBillingAddress()->getEmail();
        }

        return $email;
    }
}
