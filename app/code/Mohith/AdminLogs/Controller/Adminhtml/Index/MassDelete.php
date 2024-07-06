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
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;
use Mohith\AdminLogs\Api\AdminLogsRepositoryInterface;

/**
 * Class MassDelete
 * @package Mohith\AdminLogs\Controller\Adminhtml\Index
 */
class MassDelete extends Action
{
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var AdminLogsRepositoryInterface
     */
    private $adminLogsRepository;

    /**
     * MassDelete constructor.
     * @param Action\Context $context
     * @param Filter $filter
     * @param AdminLogsRepositoryInterface $adminLogsRepository
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        AdminLogsRepositoryInterface $adminLogsRepository
    ) {
        parent::__construct($context);
        $this->filter = $filter;
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
            $collection = $this->filter->getCollection($this->adminLogsRepository->getCollection());
            $deletedItems = 0;
            foreach ($collection as $item) {
                try {
                    $this->adminLogsRepository->delete($item);
                    $deletedItems++;
                } catch (CouldNotDeleteException $couldNotDeleteException) {
                    $this->messageManager->addErrorMessage($couldNotDeleteException->getMessage());
                }
            }
            $this->messageManager->addSuccessMessage(__("%1 items deleted", $deletedItems));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->resultRedirectFactory->create()->setRefererOrBaseUrl();
    }
}
