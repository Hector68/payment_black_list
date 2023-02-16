<?php

namespace Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList;

class Index extends \Ronzhin\PaymentBlackList\Controller\Adminhtml\BlackList
{
    /** @var \Magento\Framework\View\Result\PageFactory */
    private $resultPageFactory;

    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    private $dataPersistor;

    /**
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Black List'));

        $this->dataPersistor->clear('payment_black_list_blacklist');
        return $resultPage;
    }
}
