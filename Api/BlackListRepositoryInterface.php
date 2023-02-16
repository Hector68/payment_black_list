<?php

namespace Ronzhin\PaymentBlackList\Api;

interface BlackListRepositoryInterface
{
    /**
     * Save BlackList
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface
     */
    public function save(Data\BlackListInterface $entity);

    /**
     * Retrieve BlackList
     * @param int $entityId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface
     */
    public function getById($entityId);

    /**
     * Retrieve BlackList entities matching the specified criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Ronzhin\PaymentBlackList\Api\Data\BlackListSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete BlackList
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function delete(Data\BlackListInterface $entity);

    /**
     * Delete BlackList
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function deleteById($entityId);
}
