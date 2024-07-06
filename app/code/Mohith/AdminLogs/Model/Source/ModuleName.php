<?php
/**
 *
 * @package     Mohith
 * @author      Mohith Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Model\Source;

/**
 * Class ModuleName
 * @package Mohith\AdminLogs\Model\Source
 */
class ModuleName extends AbstractTable
{

    protected function getTableData()
    {
        return [
            'module_name'  =>  [
                'label' =>  __("Module Name")
            ]
        ];
    }
}
