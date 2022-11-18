<?php

namespace Cowell\BasicTraining\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class MyEvent implements ObserverInterface
{
    protected $logger;
    public function __construct()
    {
        $this->logger = \Magento\Framework\App\ObjectManager::getInstance()->get('\Psr\Log\LoggerInterface');
    }

    public function execute(Observer $observer)
    {
        $this->logger->debug('Event Save Product - DucNV');
    }

}
