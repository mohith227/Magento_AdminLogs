<?php
/**
 *
 * @package     Mohith
 * @author      Mohith Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Block\Adminhtml\System\Form\Field;

/**
 * Class Select
 * @package Mohith\AdminLogs\Block\Adminhtml\System\Form\Field
 */
class Select extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * @return string
     */
    protected function _toHtml()
    {
        $this->setName($this->getInputName());
        $this->setClass('select');
        return trim(preg_replace('/\s+/', ' ', parent::_toHtml()));
    }
}
