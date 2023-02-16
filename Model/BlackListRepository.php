<?php

namespace Ronzhin\PaymentBlackList\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BlackListRepository implements \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface
{
    /** @var \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList */
    private $resource;

    /** @var \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList\CollectionFactory */
    private $collectionFactory;

    /** @var \Ronzhin\PaymentBlackList\Api\Data\BlackListInterfaceFactory */
    private $entityFactory;

    /** @var \Ronzhin\PaymentBlackList\Api\Data\BlackListSearchResultsInterfaceFactory */
    private $searchResultsFactory;

    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    /**
     * @param \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList $resource
     * @param \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList\CollectionFactory $collectionFactory
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListInterfaceFactory $entityFactory
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceModel\BlackList $resource,
        ResourceModel\BlackList\CollectionFactory $collectionFactory,
        \Ronzhin\PaymentBlackList\Api\Data\BlackListInterfaceFactory $entityFactory,
        \Ronzhin\PaymentBlackList\Api\Data\BlackListSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->entityFactory = $entityFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface
     */
    public function getById($entityId)
    {
        $entity = $this->entityFactory->create();
        $this->resource->load($entity, $entityId);
        if (!$entity->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Payment Black List Black List with id "%1" does not exist.', $entityId)
            );
        }
        return $entity;
    }

    /**
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface
     */
    public function save(\Ronzhin\PaymentBlackList\Api\Data\BlackListInterface $entity)
    {
        try {
            $this->resource->save($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __($exception->getMessage())
            );
        }
        return $entity;
    }

    /**
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function delete(\Ronzhin\PaymentBlackList\Api\Data\BlackListInterface $entity)
    {
        try {
            $this->resource->delete($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(
                __($exception->getMessage())
            );
        }
        return true;
    }

    /**
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Ronzhin\PaymentBlackList\Api\Data\BlackListSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var \Ronzhin\PaymentBlackList\Api\Data\BlackListSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
