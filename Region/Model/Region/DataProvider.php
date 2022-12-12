<?php
//
//namespace Cowell\Region\Model\Region;
//
//use Cowell\Region\Model\ResourceModel\Region\CollectionFactory;
//use Magento\Framework\App\Request\DataPersistorInterface;
//use Magento\Ui\DataProvider\AbstractDataProvider;
//
//class DataProvider extends AbstractDataProvider
//{
//
//    /**
//     * @inheritDoc
//     */
//    protected $collection;
//
//    /**
//     * @var DataPersistorInterface
//     */
//    protected $dataPersistor;
//
//    /**
//     * @var array
//     */
//    protected $loadedData;
//
//    /**
//     * @param string $name
//     * @param string $primaryFieldName
//     * @param string $requestFieldName
//     * @param CollectionFactory $collectionFactory
//     * @param DataPersistorInterface $dataPersistor
//     * @param array $meta
//     * @param array $data
//     */
//    public function __construct(
//        $name,
//        $primaryFieldName,
//        $requestFieldName,
//        CollectionFactory $collectionFactory,
//        DataPersistorInterface $dataPersistor,
//        array $meta = [],
//        array $data = []
//    ) {
//        $this->collection = $collectionFactory->create();
//        $this->dataPersistor = $dataPersistor;
//        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function getData()
//    {
//        if (isset($this->loadedData)) {
//            return $this->loadedData;
//        }
//        $items = $this->collection->getItems();
//        foreach ($items as $model) {
//            $this->loadedData[$model->getId()] = $model->getData();
//        }
//        $data = $this->dataPersistor->get('directory_country_region');
//
//        if (!empty($data)) {
//            $model = $this->collection->getNewEmptyItem();
//            $model->setData($data);
//            $this->loadedData[$model->getId()] = $model->getData();
//            $this->dataPersistor->clear('directory_country_region');
//        }
//
//        return $this->loadedData;
//    }
//}
//
