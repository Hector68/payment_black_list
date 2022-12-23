<?php

namespace Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList;

use Magento\Framework\Exception\LocalizedException;
use Ronzhin\PaymentBlackList\Api\Data\BlackListInterface;

class Save extends \Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList
{
    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    private $dataPersistor;

    /** @var \Ronzhin\PaymentBlackList\Api\Data\BlackListInterfaceFactory */
    private $entityFactory;

    /**
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Ronzhin\PaymentBlackList\Api\Data\BlackListInterfaceFactory $entityFactory
     * @param \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Ronzhin\PaymentBlackList\Api\Data\BlackListInterfaceFactory $entityFactory,
        \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->entityFactory = $entityFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Save BlackList action
     *
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }
        $entityId = $this->getRequest()->getParam('id');
        $entity = $this->entityFactory->create();
        if ($entityId) {
            try {
                $entity = $this->repository->getById($entityId);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                if (!$entity->getId() && $entityId) {
                    $this
                        ->messageManager
                        ->addErrorMessage(__('This Black List no longer exists'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
        }
        if (empty($data['id'])) {
            $data['id'] = null;
        }

        $data = $this->handleInputData($data);

        $entity->setData($data);
        try {
            $this->repository->save($entity);
            $this->messageManager->addSuccessMessage(__('You saved the Black List'));
            $this->dataPersistor->clear('payment_black_list_blacklist');
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $entity->getId()]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Black List'));
        }
        $this->dataPersistor->set('payment_black_list_blacklist', $data);
        return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
    }

    /**
     * @param array $data
     * @return array
     */
    private function handleInputData(array $data): array
    {
        $fieldType =  (int)($data['field_type'] ?? 0);
        if(!empty($data['field_value'])){
            $data['field_value'] = mb_strtolower(trim($data['field_value']));
            if($fieldType === BlackListInterface::TYPE_PHONE){
                $phone = preg_replace('/\D/', '', $data['field_value']);
                if(strlen($phone) === 11 && in_array($phone[0], ['7','8'])){
                    $phone =  substr($phone, 1);
                }
                $data['field_value'] = $phone;
            }
        }
        return $data;
    }
}
