<?php

namespace Ronzhin\PaymentBlackList\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Configuration
{

    public const XML_PATH_IS_ENABLED = 'ronzhin_payment_blacklist/general/enabled';
    public const XML_PATH_METHOD_MAP = 'ronzhin_payment_blacklist/general/method_mapping';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface  $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_IS_ENABLED);
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function canCheckPaymentMethod(string $methodName): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $paymentMapJson = $this->scopeConfig->getValue(self::XML_PATH_METHOD_MAP);
        $paymentMapArray = $this->serializer->unserialize($paymentMapJson);

        return (bool)($paymentMapArray[$methodName]['is_active'] ?? false);
    }

}
