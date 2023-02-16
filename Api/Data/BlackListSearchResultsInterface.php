<?php

namespace Ronzhin\PaymentBlackList\Api\Data;

interface BlackListSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get list of BlackList
     * @return \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface[]
     */
    public function getItems();

    /**
     * Set list of BlackList
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface[] $items
     */
    public function setItems(array $items);
}
