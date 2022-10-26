<?php

namespace Cowell\BasicTraining\Controller\Adminhtml\Training;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Filesystem;

class Save extends \Cowell\BasicTraining\Controller\Adminhtml\Student implements HttpPostActionInterface
{

    protected $dataPersistor;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Filesystem $filesystem,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        Registry $coreRegistry
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context, $coreRegistry);
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('id');

            $model = $this->_objectManager->create(\Cowell\BasicTraining\Model\Student::class)->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Student no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
//            $data['image'] = $this->mediaDirectory->getRelativePath('catalog/tmp/category') . '/' . $data['image'][0]['file'];
//            $model->setData($data);
            if (isset($data['image']) && is_array($data['image'])) {
                $strpos = strpos($data['image'][0]['url'], '/media/');
                $data['image'][0]['url'] = substr($data['image'][0]['url'], $strpos + 6);
                $data['image'][0]['url'] = trim($data['image'][0]['url'], '/');
                $data['image'] = json_encode($data['image']);
                $model->setData($data);
            }
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Student.'));
                $this->dataPersistor->clear('student');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the student.'));
            }

            $this->dataPersistor->set('student', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

}
