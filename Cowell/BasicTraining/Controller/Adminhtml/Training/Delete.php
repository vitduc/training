<?php

namespace Cowell\BasicTraining\Controller\Adminhtml\Training;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;

class Delete extends \Cowell\BasicTraining\Controller\Adminhtml\Student implements HttpPostActionInterface
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        Filesystem $fileSystem,
        File $file
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->fileSystem = $fileSystem;
        $this->file = $file;
        parent::__construct($context, $coreRegistry);

    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->getUrl('pub/media');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Cowell\BasicTraining\Model\Student::class);
                $model->load($id);
                $file_path = $model->load($id)->getImage();
                $mediaRootDir = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                if ($this->file->isExists($mediaRootDir. 'catalog/tmp/category' . $file_path)) {
                    $this->file->deleteFile($mediaRootDir . $file_path);
                }
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Student.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Training to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
