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
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class StudentRepository implements StudentRepositoryInterface
{

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

    /**
     * @param ResourceStudent $resource
     * @param StudentInterfaceFactory $studentFactory
     * @param StudentCollectionFactory $studentCollectionFactory
     * @param StudentSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceStudent                      $resource,
        StudentInterfaceFactory              $studentFactory,
        StudentCollectionFactory             $studentCollectionFactory,
        StudentSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\App\RequestInterface $request,
        CollectionProcessorInterface         $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->studentFactory = $studentFactory;
        $this->studentCollectionFactory = $studentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->request = $request;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * @inheritDoc
     */
    public function save(StudentInterface $student)
    {
        try {
            $this->resource->save($student);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the student: %1',
                $exception->getMessage()
            ));
        }
        return $student;
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

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ) {
        $collection = $this->studentCollectionFactory->create();
        $get_id = $this->request->getParam('id') ? $this->request->getParam('id') : 'ASC';
        $collection->addOrder('id', 'DESC');

        $this->getCollectionProcessor()->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

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
     * @deprecated
     * @return \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     **/
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Magento\Eav\Model\Api\SearchCriteria\CollectionProcessor'
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
