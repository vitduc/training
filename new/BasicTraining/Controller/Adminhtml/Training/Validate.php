<?php

namespace Cowell\BasicTraining\Controller\Adminhtml\Training;

use Cowell\BasicTraining\Model\ResourceModel\Student\CollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Serialize\Serializer\Json;

class Validate extends Action
{
    protected $_json;
    protected $_resultJsonFactory;
    protected $_collectionFactory;

    public function __construct(
        Context           $context,
        Json              $json,
        JsonFactory       $resultJsonFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->_json = $json;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $request = $this->getRequest()->getParams();
        $studentName = $request["name"] ;
        $studentId= $request["id"] ?? null;
        $resultJson = $this->_resultJsonFactory->create();
        $validatedResponse = new \Magento\Framework\DataObject();
        $collection = $this->_collectionFactory->create()->addFieldToFilter('name',$studentName);
        $oldName = $collection->getItemById($studentId)['name'] ?? '';
        if ($studentName && $oldName != $studentName) {
            if($collection->getSize() > 0){
                $validatedResponse->setError(true);
                $validatedResponse->setMessages(['text'=> 'This name was taken']);
            }
        }
        return $resultJson->setData($validatedResponse);
    }
}
