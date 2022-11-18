<?php

namespace Cowell\BasicTraining\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Student extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('students', 'id');
    }

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface   $productRepository,
    ) {
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    public function getStudent($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(['catalog_product_student'])
            ->where('student_id =' . $id);
        $array = $connection->fetchAll($select);
        $product = [];
        foreach ($array as $item) {
            $productId = $item['product_id'];
            $product[] = $this->productRepository->getById($productId);
        }
        return $product;
    }

}
