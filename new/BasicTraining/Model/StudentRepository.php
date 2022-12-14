<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Cowell\BasicTraining\Model;

use Cowell\BasicTraining\Api\Data\StudentInterface;
use Cowell\BasicTraining\Api\Data\StudentInterfaceFactory;
use Cowell\BasicTraining\Api\Data\StudentSearchResultsInterfaceFactory;
use Cowell\BasicTraining\Api\StudentRepositoryInterface;
use Cowell\BasicTraining\Model\ResourceModel\Student as ResourceStudent;
use Cowell\BasicTraining\Model\ResourceModel\Student\CollectionFactory as StudentCollectionFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class StudentRepository implements StudentRepositoryInterface
{
    protected $product_resource;

    /**
     * @var ResourceStudent
     */
    protected $resource;

    /**
     * @var StudentInterfaceFactory
     */
    protected $studentFactory;

    /**
     * @var StudentCollectionFactory
     */
    protected $studentCollectionFactory;

    /**
     * @var Student
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    protected $extensibleDataObjectConverter;


    /**
     * @param ResourceStudent $resource
     * @param StudentInterfaceFactory $studentFactory
     * @param StudentCollectionFactory $studentCollectionFactory
     * @param StudentSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceStudent                           $resource,
        \Magento\Framework\App\ResourceConnection $product_resource,
        StudentFactory                            $studentFactory,
        StudentCollectionFactory                  $studentCollectionFactory,
        StudentSearchResultsInterfaceFactory      $searchResultsFactory,
        ExtensibleDataObjectConverter             $extensibleDataObjectConverter,
        CollectionProcessorInterface              $collectionProcessor = null,
    ) {
        $this->resource = $resource;
        $this->connection = $product_resource->getConnection();
        $this->studentFactory = $studentFactory;
        $this->studentCollectionFactory = $studentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    public function getStd($id)
    {
        $pro = $this->resource->getStudent($id);
        return $pro;
    }

    /**
     * @inheritDoc
     */
    public function save(StudentInterface $student)
    {
        $studentData = $this->extensibleDataObjectConverter->toNestedArray(
            $student,
            [],
            StudentInterface::class
        );

        $studentModel = $this->studentFactory->create()->setData($studentData);

        try {
            $this->resource->save($studentModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the training: %1',
                $exception->getMessage()
            ));
        }
        return $studentModel->getDataModel();
    }

    /**
     * @inheritDoc
     */
    public function get($studentId)
    {
        $student = $this->studentFactory->create();
        $this->resource->load($student, $studentId);
        if (!$student->getId()) {
            throw new NoSuchEntityException(__('Student with id "%1" does not exist.', $studentId));
        }
        return $student;
    }

    public function getPr()
    {
        $select = $this->connection->select()
            ->from(
                ['cpe' => 'catalog_product_entity'],
                ['sku']
            )
            ->join(['ccp' => 'catalog_category_product'], 'cpe.entity_id = ccp.product_id', 'ccp.category_id')
//            ->where('cpe.has_options = 1')->orWhere('cpe.required_options = 1')
            ->columns(['categoryCount' => 'COUNT(ccp.category_id)'])
            ->group('category_id')
            ->having('categoryCount > 100')
            ->order('ccp.category_id');
        return $this->connection->fetchAll($select);
    }

    public function insertStudent()
    {
//        $this->connection->insert('students', [
//            'name' => 'nvduc',
//            'dob' => '2022-10-04',
//            'address' => 'viet nam',
//            'gender' => '1'
//        ]);

//        $this->connection->insertArray(
//            'students',
//            [
//                'name',
//                'dob',
//                'address',
//                'gender'
//            ],
//            $data = [
//                ['duc', '2022-10-04', 'viet nam', '1'],
//                ['duc', '2022-10-04', 'viet nam', '1']
//            ]
//        );

        $this->connection->insertForce('students', [
            'id' => 333,
            'name' => 'nvduc insert force',
            'dob' => '2022-10-04',
            'address' => 'viet nam',
            'gender' => '1'
        ]); //ảnh hưởng đến việc xử lý các cột AUTO_INCREMENT.
//
//        $this->connection->insertFromSelect(
//            $this->connection->select(),
//            'students',
//            [
//                'name', 'address'
//            ],
//            AdapterInterface::INSERT_ON_DUPLICATE
//        );
//        $this->connection->insertMultiple();
    }

    /**
     * @return CollectionProcessorInterface
     */
    public function updateStudent()
    {
        $this->connection->update('students', ['name' => 'duc test update'], 'id = 33');
    }

    /**
     * @return CollectionProcessorInterface
     */
    public function deleteStudent()
    {
//        $this->connection->delete('students', 'id = 30');
//        $this->connection->deleteFromSelect();
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->studentCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Retrieve collection processor
     *
     * @return \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     **@deprecated
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Magento\Framework\Api\SearchCriteria\CollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function delete(StudentInterface $student)
    {
        try {
            $studentModel = $this->studentFactory->create();
            $this->resource->load($studentModel, $student->getStudentId());
            $this->resource->delete($studentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Student: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($studentId)
    {
        return $this->delete($this->get($studentId));
    }

}
