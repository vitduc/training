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
        Context $context,
        Json $json,
        JsonFactory $resultJsonFactory,
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
        $name = $data["name"] ?? '';
        $resultJson = $this->_resultJsonFactory->create();
        $collectionFactory = $this->_collectionFactory->create();
        $collectionFactory->addFieldToFilter('name', $name);

        $collection = $this->_collectionFactory->create()->getData();
        $count_name = count($collection);
        $validatedResponse = new \Magento\Framework\DataObject();
//        if (!$get_id) {
//            foreach ($collection as $item) {
//                if ($name == $item['name']) {
//                    $validatedResponse->setError(true);
//                    $validatedResponse->setMessages(['text' => 'Lỗi: Tên sinh viên đã tồn tại']);
//                    return $resultJson->setData($validatedResponse);
//                }
//            }
//        } else{
//            foreach ($collection as $item) {
//                if ($name == $item['name'])
//                    $validatedResponse->setError(true);
//                    $validatedResponse->setMessages(['text' => 'Lỗi: Tên sinh viên đã tồn tại']);
//                    return $resultJson->setData($validatedResponse);
//                }
//            }
//        }
//        return $resultJson->setData($validatedResponse);
    }
}
