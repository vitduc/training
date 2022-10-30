<?php

namespace Cowell\BasicTraining\Model\Student;

use Cowell\BasicTraining\Model\ResourceModel\Student\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $dataPersistor;

    protected $collection;

    protected $loadedData;

    protected  $imageHelper;
    /**
     * Constructor
     *
     * @param \Cowell\BasicTraining\Model\Student\Image $imageHelper
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        Image $imageHelper,
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->imageHelper = $imageHelper;
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
            if ($model->getImage()) {
                $m[0]['url'] = $this->imageHelper->getBaseUrl() . $model->getImage();
                $m[0]['file'] = $model->getImage();
                $this->loadedData[$model->getId()]['image'] = $m;
            }
        }
        $data = $this->dataPersistor->get('student');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('student');
        }
        return $this->loadedData;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();

        return $meta;
    }
}
