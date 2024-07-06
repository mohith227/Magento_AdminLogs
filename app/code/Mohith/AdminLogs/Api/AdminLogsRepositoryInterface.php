<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mohith\AdminLogs\Api\Data\AdminLogsInterface;
use Mohith\AdminLogs\Model\ResourceModel\AdminLogs\Collection;

/**
 * Interface AdminLogsRepositoryInterface
 * @package Mohith\AdminLogs\Api
 */
interface AdminLogsRepositoryInterface
{
    /**
     * @param string $value
     * @param string|null $field
     * @return AdminLogsInterface
     * @throws NoSuchEntityException
     */
    public function load($value, $field = null);

    /**
     * @return AdminLogsInterface
     */
    public function create();

    /**
     * @param AdminLogsInterface $model
     * @return AdminLogsInterface
     * @throws CouldNotSaveException
     */
    public function save(AdminLogsInterface $model);

    /**
     * @param AdminLogsInterface $model
     * @return $this
     * @throws CouldNotDeleteException
     */
    public function delete(AdminLogsInterface $model);

    /**
     * @return Collection
     */
    public function getCollection();
}
