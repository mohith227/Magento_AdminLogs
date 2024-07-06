<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class AdminLogs
 * @package Mohith\AdminLogs\Model\ResourceModel
 */
class AdminLogs extends AbstractDb
{

    const TABLE_NAME = "mohith_admin_logs";

    const ID_FIELD_NAME = "mohith_admin_logs_id";

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}
