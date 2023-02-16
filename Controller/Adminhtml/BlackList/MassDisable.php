<?php

namespace Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList;

use Magento\Framework\Controller\ResultFactory;
use Ronzhin\PaymentBlackList\Api\Data\BlackListInterface;

class MassDisable extends \Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList
{
    /** @var \Magento\Ui\Component\MassAction\Filter */
    private $filter;

    /** @var \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList\CollectionFactory */
    private $collectionFactory;

    /**
     * @param \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList\CollectionFactory $collectionFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Ronzhin\PaymentBlackList\Model\ResourceModel\BlackList\CollectionFactory $collectionFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $entity) {
            /**
             * @var BlackListInterface $entity
             */
            $entity->setIsActive(BlackListInterface::INACTIVE_VALUE);
            $this->repository->save($entity);
        }
        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deactivated.', $collectionSize)
        );
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
