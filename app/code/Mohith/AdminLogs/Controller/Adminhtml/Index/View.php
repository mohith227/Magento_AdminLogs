<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\Page;
use Mohith\AdminLogs\Api\AdminLogsRepositoryInterface;

/**
 * Class View
 * @package Mohith\AdminLogs\Controller\Adminhtml\Index
 */
class View extends Action
{
    const ADMIN_RESOURCE = "Mohith_AdminLogs::view";

    /**
     * @var AdminLogsRepositoryInterface
     */
    private $adminLogsRepository;

    /**
     * View constructor.
     * @param Action\Context $context
     * @param AdminLogsRepositoryInterface $adminLogsRepository
     */
    public function __construct(
        Action\Context $context,
        AdminLogsRepositoryInterface $adminLogsRepository
    ) {
        parent::__construct($context);
        $this->adminLogsRepository = $adminLogsRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        try {
            $log = $this->adminLogsRepository->load($this->getRequest()->getParam('id'));
            /** @var Page $page */
            $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $page->getConfig()->getTitle()->set(__('Admin Log #%1', $log->getId()));
            return $page;
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            return $this->resultRedirectFactory->create()->setRefererOrBaseUrl();
        }
    }
}
