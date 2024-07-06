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
 * Class FullActionName
 * @package Mohith\AdminLogs\Model\Source
 */
class FullActionName extends AbstractTable
{

    protected function getTableData()
    {
        return [
            'full_action_name'  =>  [
                'label' =>  __("Full Action Name")
            ]
        ];
    }
}
