<?php

namespace Cowell\BasicTraining\ViewModel;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface;

class Student extends AbstractBlock implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    protected $request;
    protected $layout;
    protected $sortOrderBuilder;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;

    public function __construct(
        Template\Context                                     $context,
        \Magento\Framework\Api\SearchCriteriaBuilder         $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface              $request,
        \Magento\Framework\Api\SortOrderBuilder              $sortOrderBuilder,
        \Cowell\BasicTraining\Api\StudentRepositoryInterface $studentInterfaceFactory,
        LayoutInterface                                      $layout,
        FilterBuilder $filterBuilder,
        array                                                $data = []
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->request = $request;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->studentInterfaceFactory = $studentInterfaceFactory;
        $this->layout = $layout;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context, $data);
    }

    /**
     * @throws LocalizedException
     */
    public function getAllStudent()
    {
        $filterData = [];
        if ($name = $this->request->getParam('key')) {
            $filter = $this->filterBuilder
                ->setField('name')
                ->setValue($name)
                ->setConditionType('eq')
                ->create();
            $filterData[] = $filter;
        }
        $searchCriteria = $this->searchCriteriaBuilder->addFilters($filterData);
        $searchCriteria = $searchCriteria->create();
        $collection = $this->studentInterfaceFactory->getList($searchCriteria);
        return $collection->getItems();
    }

    public function getProduct()
    {
        $product = $this->studentInterfaceFactory->getPr();
        return $product;
    }

    /**
     * @return LayoutInterface
     */
    public function insertStd()
    {
        $insert_std = $this->studentInterfaceFactory->insertStudent();
        return $insert_std;
    }

    public function updateStd()
    {
        $insert_std = $this->studentInterfaceFactory->updateStudent();
        return $insert_std;
    }

    public function deleteStd()
    {
        $insert_std = $this->studentInterfaceFactory->deleteStudent();
        return $insert_std;
    }
}
