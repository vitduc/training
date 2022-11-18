<?php

namespace Cowell\BasicTraining\Plugin;

use Cowell\BasicTraining\Api\Data\StudentInterface;
use Cowell\BasicTraining\Api\StudentRepositoryInterface;
use Cowell\BasicTraining\Model\ResourceModel\Student as ResourceStudent;
use Cowell\BasicTraining\Model\StudentRepository;

class ProductPlugin
{
    protected $productRepository;
    protected $resource;
    protected $std;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        ResourceStudent                                 $resource,
        StudentRepository $std
    ) {
        $this->productRepository = $productRepository;
        $this->resource = $resource;
        $this->std = $std;
    }

    public function afterGet(StudentRepositoryInterface $subject, StudentInterface $result)
    {
        $product = $this->std->getStd($result->getId());
        $studentExtension = $result->getExtensionAttributes();
        $studentExtension->setStudentLinks($product);
        if ($product) {
            $result->setExtensionAttributes($studentExtension);
        }
        return $result;
    }
}
