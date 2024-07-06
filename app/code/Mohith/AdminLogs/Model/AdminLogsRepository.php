<?php
/**
 *
 * @package     magento2
 * @author      Mohith
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 *
 */

namespace Mohith\AdminLogs\Model;

use Exception;
use Magento\Framework\App\State as AppState;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mohith\AdminLogs\Api\AdminLogsRepositoryInterface;
use Mohith\AdminLogs\Api\Data\AdminLogsInterface;
use Mohith\AdminLogs\Api\Data\AdminLogsInterfaceFactory as ModelFactory;
use Mohith\AdminLogs\Model\ResourceModel\AdminLogs as ResourceModel;
use Mohith\AdminLogs\Model\ResourceModel\AdminLogs\Collection;
use Mohith\AdminLogs\Model\ResourceModel\AdminLogs\CollectionFactory;

/**
 * Class AdminLogsRepository
 * @package Mohith\AdminLogs\Model
 */
class AdminLogsRepository implements AdminLogsRepositoryInterface
{

    /**
     * @var AdminLogsInterface[]
     */
    private $modelCache = [];

    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var AppState
     */
    private $appState;

    /**
     * AdminLogsRepository constructor.
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     * @param AppState $appState
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory,
        AppState $appState
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->appState = $appState;
    }

    /**
     * @param string $value
     * @param string|null $field
     * @return AdminLogsInterface
     * @throws NoSuchEntityException
     */
    public function load($value, $field = null)
    {
        $cacheKey = $this->getCacheKey(null, $value, $field);
        if (!array_key_exists($cacheKey, $this->modelCache)) {
            $model = $this->create();
            $this->resourceModel->load($model, $value, $field);
            if (!$model->getId()) {
                throw NoSuchEntityException::singleField($field, $value);
            }
            $this->modelCache[$cacheKey] = $model;
        }
        return $this->modelCache[$cacheKey];
    }

    /**
     * @return AdminLogsInterface
     */
    public function create()
    {
        return $this->modelFactory->create();
    }

    /**
     * @param AdminLogsInterface $model
     * @return AdminLogsInterface
     * @throws CouldNotSaveException
     */
    public function save(AdminLogsInterface $model)
    {
        try {
            /** @var AdminLogs $model */
            $model->setData('area', $this->appState->getAreaCode());
            $this->resourceModel->save($model);
        } catch (AlreadyExistsException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (Exception $e) {
            throw new CouldNotSaveException(__("Some error occurred while saving the model"));
        }
        return $model;
    }

    /**
     * @param AdminLogsInterface $model
     * @return $this
     * @throws CouldNotDeleteException
     */
    public function delete(AdminLogsInterface $model)
    {
        try {
            $this->resourceModel->delete($model);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__("Some error occurred while deleting the model"));
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    /**
     * @param AdminLogsInterface $model
     * @param string $value
     * @param string $field
     * @return string
     */
    protected function getCacheKey($model, $value = '', $field = '')
    {
        if ($model) {
            return $model->getId() . $value . $field;
        } else {
            return $value . $field;
        }
    }
}
