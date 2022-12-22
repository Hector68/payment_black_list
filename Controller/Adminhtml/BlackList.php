<?php

namespace Ronzhin\PaymentBlackList\Controller\Adminhtml;

abstract class BlackList extends \Magento\Backend\App\Action
{
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Ronzhin_PaymentBlackList::blacklist';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * BlackList repository
     *
     * @var \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface
     */
    protected $repository;

    /**
     * @param \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Ronzhin\PaymentBlackList\Api\BlackListRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->repository = $repository;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Ronzhin_PaymentBlackList::blacklist');
        return $resultPage;
    }
}
