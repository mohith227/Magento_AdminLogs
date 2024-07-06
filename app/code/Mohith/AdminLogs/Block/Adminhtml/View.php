<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Block\Adminhtml;

use function json_decode;
use function json_encode;
use Magento\Backend\Block\Template;
use Magento\Framework\Exception\NoSuchEntityException;
use Mohith\AdminLogs\Api\AdminLogsRepositoryInterface;
use Mohith\AdminLogs\Api\Data\AdminLogsInterface;

/**
 * Class View
 * @package Mohith\AdminLogs\Block\Adminhtml
 */
class View extends Template
{
    /**
     * @var AdminLogsRepositoryInterface
     */
    private $adminLogsRepository;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param AdminLogsRepositoryInterface $adminLogsRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        AdminLogsRepositoryInterface $adminLogsRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->adminLogsRepository = $adminLogsRepository;
    }

    /**
     * @return AdminLogsInterface
     */
    public function getAdminLog()
    {
        try {
            return $this->adminLogsRepository->load($this->getRequest()->getParam('id'));
        } catch (NoSuchEntityException $e) {
            return $this->adminLogsRepository->create();
        }
    }

    /**
     * @param array $jsonArray
     * @return array
     */
    protected function validateJsonArray($jsonArray)
    {
        foreach ($jsonArray as $key => $value) {
            if (@is_array(json_decode($value, true))) {
                $jsonArray[$key] = $this->validateJsonArray(json_decode($value, true));
            }
        }
        return $jsonArray;
    }

    /**
     * @param array $jsonArray
     * @return string
     */
    public function getFormattedJsonArrayHtml($jsonArray)
    {
        return sprintf('<pre>%s</pre>', json_encode($this->validateJsonArray($jsonArray), JSON_PRETTY_PRINT));
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*');
    }
}
