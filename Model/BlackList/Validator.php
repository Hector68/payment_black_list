<?php

namespace Ronzhin\PaymentBlackList\Model\BlackList;

use Magento\Framework\Validator\EmailAddress;
use Magento\Framework\Validator\Regex;
use Magento\Framework\Validator\RegexFactory;
use Ronzhin\PaymentBlackList\Api\Data\BlackListInterface;

class Validator extends \Magento\Framework\Validator\AbstractValidator
{
    /**
     * @var EmailAddress
     */
    private $emailAddressValidator;
    /**
     * @var Regex
     */
    private $phoneValidator;

    public function __construct(EmailAddress $emailAddressValidator, RegexFactory $regexValidatorFactory)
    {
        $this->emailAddressValidator = $emailAddressValidator;
        $this->phoneValidator = $regexValidatorFactory->create(['pattern' => '/^[0-9]{10}$/i']);
    }

    /**
     * @param BlackListInterface $value
     * @return bool
     * @throws \Zend_Validate_Exception
     */
    public function isValid($value)
    {
        $messages = [];

        $type = $value->getFieldType();

        switch ($type) {
            case BlackListInterface::TYPE_EMAIL:
                $email = $value->getFieldValue();
                if (!$email || !$this->emailAddressValidator->isValid($email)) {
                    $messages['invalid_value_format'] = 'Invalid email format';
                }
                break;
            case BlackListInterface::TYPE_PHONE:
                $phone = $value->getFieldValue();
                if (!$phone || !$this->phoneValidator->isValid($phone)) {
                    $messages['invalid_value_format'] = 'Invalid phone format: 0000000000';
                }
                break;
        }

        $this->_addMessages($messages);

        return empty($messages);
    }
}
