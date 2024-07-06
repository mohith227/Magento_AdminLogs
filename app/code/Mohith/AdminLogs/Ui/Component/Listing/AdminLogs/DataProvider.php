<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Ui\Component\Listing\AdminLogs;

use Mohith\AdminLogs\Api\AdminLogsRepositoryInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package Mohith\AdminLogs\Ui\Component\Listing\AdminLogs
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param AdminLogsRepositoryInterface $adminLogsRepository
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        AdminLogsRepositoryInterface $adminLogsRepository,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $adminLogsRepository->getCollection();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}
