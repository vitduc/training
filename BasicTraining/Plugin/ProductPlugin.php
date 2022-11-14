<?php

namespace Cowell\BasicTraining\Plugin;

use Cowell\BasicTraining\Model\ResourceModel\Student as ResourceStudent;
use Cowell\BasicTraining\Api\StudentRepositoryInterface;
use Cowell\BasicTraining\Api\Data\StudentInterface;

class ProductPlugin
{
    protected $productRepository;
    protected $resource;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        ResourceStudent                                 $resource
    ) {
        $this->productRepository = $productRepository;
        $this->resource = $resource;
    }

    public function afterGet(StudentRepositoryInterface $subject, StudentInterface $result)
    {
        $connection = $this->resource->getConnection();
        $select = $connection->select()->from(['catalog_product_student'])
            ->where('student_id ='.$result->getId());
        $array = $connection->fetchAll($select);
        $product = [];
        foreach ($array as $item) {
            $productId = $item['product_id'];
            $product[] = $this->productRepository->getById($productId);
        }
        $studentExtension = $result->getExtensionAttributes();
        $studentExtension->setStudentLinks($product);
        if ($product) {
            $result->setExtensionAttributes($studentExtension);
        }
        return $result;
    }
}
