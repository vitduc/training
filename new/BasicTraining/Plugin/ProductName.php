<?php

namespace Cowell\BasicTraining\Plugin;

use Magento\Catalog\Model\Product;

class ProductName
{
    private $logger;

    public function __construct()
    {
        $this->logger = \Magento\Framework\App\ObjectManager::getInstance()->get('\Psr\Log\LoggerInterface');
    }

    public function beforeSetName(Product $subject, $name)
    {
        $this->logger->debug('beforeSetName - nv duc');
        $name = $name . '>>';
        return $name;
    }

    public function afterGetName(Product $subject, $result)
    {
        return $result . '- afterGetName';
    }

    public function aroundGetName(Product $subject, \Closure $proceed)
    {
        $this->logger->debug('DucNV-around-begin');
        $returnValue = $proceed();
        $this->logger->debug('DucNV-around-end');
        return $returnValue;
    }
}
