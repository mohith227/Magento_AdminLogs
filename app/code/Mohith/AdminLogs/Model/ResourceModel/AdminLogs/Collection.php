<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Model\ResourceModel\AdminLogs;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mohith\AdminLogs\Model\AdminLogs as Model;
use Mohith\AdminLogs\Model\ResourceModel\AdminLogs as ResourceModel;

/**
 * Class Collection
 * @package Mohith\AdminLogs\Model\ResourceModel\AdminLogs
 */
class Collection extends AbstractCollection
{

    protected $_mainTable = ResourceModel::TABLE_NAME;
    protected $_idFieldName = ResourceModel::ID_FIELD_NAME;

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
