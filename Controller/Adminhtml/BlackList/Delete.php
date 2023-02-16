<?php

namespace Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList;

class Delete extends \Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList
{
    /**
     * Delete Black List action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $entityId = $this->getRequest()->getParam('id');
        if (!$entityId) {
            $this->messageManager->addErrorMessage(__('We can not find a Black List to delete.'));
            return $resultRedirect->setPath('*/*/');
        }
        try {
            $this->repository->deleteById($entityId);
            $this->messageManager->addSuccessMessage(__('You deleted the Black List'));
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/edit', ['id' => $entityId]);
    }
}
