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
        $data = $this->getRequest()->getPostValue();
        $get_id = $this->getRequest()->getParam('id');
        $name_input = $data["name"] ?? '';
        $resultJson = $this->_resultJsonFactory->create();
        $collectionFactory = $this->_collectionFactory->create();
        $name_data = $collectionFactory->addFieldToFilter('id', $get_id)->getFirstItem()->getName();
        $collectionFactory->addFieldToFilter('name', $name_input);
        $count_name = count($collectionFactory);
        $validatedResponse = new \Magento\Framework\DataObject();
        if ($get_id) {
            if ($count_name > 0 && $name_input != $name_data) {
                $validatedResponse->setError(true);
                $validatedResponse->setMessages(['text' => 'Lỗi: Tên sinh viên đã tồn tại']);
                return $resultJson->setData($validatedResponse);
            }
        } else {
            if ($count_name > 0) {
                $validatedResponse->setError(true);
                $validatedResponse->setMessages(['text' => 'Lỗi: Tên sinh viên đã tồn tại']);
                return $resultJson->setData($validatedResponse);
            }
        }
        return $resultJson->setData($validatedResponse);
    }
}
