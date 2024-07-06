<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Ui\Component\Listing\Column\AdminLogs;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Mohith\AdminLogs\Model\ResourceModel\AdminLogs as ResourceModel;

/**
 * Class Actions
 * @package Mohith\AdminLogs\Ui\Component\Listing\Column\AdminLogs
 */
class Actions extends Column
{
    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * Actions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $url,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->url = $url;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[ResourceModel::ID_FIELD_NAME])) {
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->url->getUrl(
                                'adminlogs/index/view',
                                [
                                    'id'    =>  $item[ResourceModel::ID_FIELD_NAME]
                                ]
                            ),
                            'label' => __('View')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
