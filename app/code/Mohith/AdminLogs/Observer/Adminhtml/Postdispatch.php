<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Observer\Adminhtml;

use Mohith\AdminLogs\Api\AdminLogsRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Mohith\Logger\Logger\Logger;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Registry;

/**
 * Class Postdispatch
 * @package Mohith\AdminLogs\Observer\Adminhtml
 */
class Postdispatch implements ObserverInterface
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var ManagerInterface
     */
    private $messageManager;
    /**
     * @var AdminLogsRepositoryInterface
     */
    private $adminLogsRepository;
    /**
     * @var Logger
     */
    private $monolog;

    /**
     * Postdispatch constructor.
     * @param Registry $registry
     * @param ManagerInterface $messageManager
     * @param AdminLogsRepositoryInterface $adminLogsRepository
     * @param Logger $monolog
     */
    public function __construct(
        Registry $registry,
        ManagerInterface $messageManager,
        AdminLogsRepositoryInterface $adminLogsRepository,
        Logger $monolog
    ) {
        $this->registry = $registry;
        $this->messageManager = $messageManager;
        $this->adminLogsRepository = $adminLogsRepository;
        $this->monolog = $monolog;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $log = $this->registry->registry(\Mohith\AdminLogs\Model\ResourceModel\AdminLogs::TABLE_NAME);
        if ($log instanceof \Mohith\AdminLogs\Api\Data\AdminLogsInterface) {
            $messages = [];
            foreach ($this->messageManager->getMessages()->getItems() as $message) {
                $messages[] = [
                    'type'  =>  $message->getType(),
                    'text'  =>  $message->getText()
                ];
            }
            $log->setPostActionMessages($messages);
            try {
                $this->adminLogsRepository->save($log);
                $this->log("Admin log successful");
            } catch (CouldNotSaveException $e) {
                $this->log($e->getMessage());
            }
        }
    }

    protected function log($message) {
        $this->monolog->info("Mohith ADMIN LOGS: $message");
    }
}
