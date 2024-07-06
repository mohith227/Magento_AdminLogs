<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Model;

use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Mohith\AdminLogs\Api\AdminLogsManagementInterface;
use Mohith\AdminLogs\Api\AdminLogsRepositoryInterface;
use Mohith\AdminLogs\Api\Data\AdminLogsInterface;

/**
 * Class AdminLogsManagement
 * @package Mohith\AdminLogs\Model
 */
class AdminLogsManagement implements AdminLogsManagementInterface
{
    /**
     * @var AdminLogsRepositoryInterface
     */
    private $adminLogsRepository;
    /**
     * @var AuthSession
     */
    private $authSession;
    /**
     * @var RemoteAddress
     */
    private $remoteAddress;
    /**
     * @var Config
     */
    private $config;

    /**
     * AdminLogsManagement constructor.
     * @param AdminLogsRepositoryInterface $adminLogsRepository
     * @param AuthSession $authSession
     * @param RemoteAddress $remoteAddress
     * @param Config $config
     */
    public function __construct(
        AdminLogsRepositoryInterface $adminLogsRepository,
        AuthSession $authSession,
        RemoteAddress $remoteAddress,
        Config $config
    ) {
        $this->adminLogsRepository = $adminLogsRepository;
        $this->authSession = $authSession;
        $this->remoteAddress = $remoteAddress;
        $this->config = $config;
    }

    /**
     * @param RequestInterface $request
     * @return AdminLogsInterface|null
     */
    public function buildLog(RequestInterface $request)
    {
        $user = $this->authSession->getUser();
        if ($user && $this->requestIsAllowed($request)) {
            $log = $this->adminLogsRepository->create();
            $log->setActionType($request->getFullActionName())
                ->setActionData($this->getLoggableParams($request))
                ->setUsername($user->getUserName())
                ->setIpAddress($this->remoteAddress->getRemoteAddress());
            return $log;
        } else {
            return null;
        }
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    protected function getLoggableParams($request)
    {
        $params = $request->getParams();
        $unLoggableParams = ["key", "formKey", "form_key"];
        foreach ($unLoggableParams as $unLoggableParam) {
            if (array_key_exists($unLoggableParam, $params)) {
                unset($params[$unLoggableParam]);
            }
        }
        return $params;
    }

    /**
     * @param string $username
     * @return AdminLogsInterface[]
     */
    public function getLogsByUsername($username)
    {
        return $this->getFilteredCollection($username, 'username');
    }

    /**
     * @param string $actionType
     * @return AdminLogsInterface[]
     */
    public function getLogsByActionType($actionType)
    {
        return $this->getFilteredCollection($actionType, 'action_type');
    }

    /**
     * @param $value
     * @param $field
     * @return DataObject[]|AdminLogsInterface[]
     */
    protected function getFilteredCollection($value, $field)
    {
        return $this->adminLogsRepository->getCollection()->addFieldToFilter($field, $value)->getItems();
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    protected function requestIsAllowed($request)
    {
        $allowedRequests = $this->config->getAllowedRequests();
        $fullActionName = $request->getFullActionName();
        $moduleName = $request->getModuleName();
        $blacklistedModules = $this->config->getBlacklistedModules();
        $whitelistedModules = $this->config->getWhitelistedModules();
        $whitelist = $this->config->getWhitelistedActions();
        $blacklist = $this->config->getBlacklistedActions();
        return (
                in_array($fullActionName, $whitelist) ||
                in_array($moduleName, $whitelistedModules)
            ) ||
            (
                !in_array($fullActionName, $blacklist) &&
                in_array($_SERVER['REQUEST_METHOD'], $allowedRequests) &&
                !in_array($moduleName, $blacklistedModules)
            );
    }
}
