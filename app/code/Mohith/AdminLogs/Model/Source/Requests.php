<?php
/**
 *
 * @package     Mohith
 * @author      Mohith Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Requests
 * @package Mohith\AdminLogs\Model\Source
 */
class Requests implements OptionSourceInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->toArray() as $item) {
            $result[] = [
                'value' =>  $item,
                'label' =>  $item
            ];
        }
        return $result;
    }

    public function toArray()
    {
        return [
            "GET",
            "POST",
            "PUT",
            "UPDATE",
            "DELETE"
        ];
    }
}
