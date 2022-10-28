<?php

namespace Cowell\BasicTraining\Controller\Adminhtml\Training;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Registry;

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
        Registry $coreRegistry,
        Filesystem $fileSystem,
        File $file
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->fileSystem = $fileSystem;
        $this->file = $file;
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

//        neu co du lieu
        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $model = $this->_objectManager->create(\Cowell\BasicTraining\Model\Student::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Student no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

//            check ton tai trong db
            $image = $model->getImage();
//            $input_image = $data['image'][0]['file'];
//            input != trong db thi xoa
            if ($image &&  $image != $data['image'][0]['file']) {
                $mediaRootDir = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                if ($this->file->isExists($mediaRootDir . 'catalog/tmp/category/' . $image)) {
                    $this->file->deleteFile($mediaRootDir . 'catalog/tmp/category/' . $image);
                }
            }
            if (isset($data['image'][0]['file'])) {
                $data['image'] = $data['image'][0]['file'];
            }
            $model->setData($data);

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
