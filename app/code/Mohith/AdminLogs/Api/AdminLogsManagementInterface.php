<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Api;

use Magento\Framework\App\RequestInterface;
use Mohith\AdminLogs\Api\Data\AdminLogsInterface;

/**
 * Interface AdminLogsManagementInterface
 * @package Mohith\AdminLogs\Api
 */

interface AdminLogsManagementInterface
{
    /**
     * @param RequestInterface $request
     * @return AdminLogsInterface|null
     */
    public function buildLog(RequestInterface $request);

    /**
     * @param string $username
     * @return AdminLogsInterface[]
     */
    public function getLogsByUsername($username);

    /**
     * @param string $actionType
     * @return AdminLogsInterface[]
     */
    public function getLogsByActionType($actionType);
}
