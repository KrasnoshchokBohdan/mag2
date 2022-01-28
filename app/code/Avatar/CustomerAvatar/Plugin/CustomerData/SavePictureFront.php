<?php

namespace Avatar\CustomerAvatar\Plugin\CustomerData;

use Magento\Customer\Controller\Account\EditPost;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Controller\Result\Redirect;
use Avatar\CustomerAvatar\Model\MediaCustomerPath;

class SavePictureFront
{
    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;
    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;
    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;
    /**
     * @var MediaCustomerPath
     */
    private $mediaCustomerPath;
    /**
     * @var RedirectFactory
     */
    private $resultRedirectFactory;

    public function __construct(
        MediaCustomerPath $mediaCustomerPath,
        RedirectFactory $resultRedirectFactory,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        CurrentCustomer $currentCustomer
    ) {
        $this->mediaCustomerPath = $mediaCustomerPath;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * @param EditPost $subject
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    public function afterExecute(EditPost $subject, Redirect $resultRedirect)
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $subject->getRequest()->getParams();
        if ($data) {
            $files = $subject->getRequest()->getFiles();
            if (isset($files['filesubmission']) && !empty($files['filesubmission']["name"])) {
                try {
                    $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'filesubmission']);
                    //check upload file type or extension
                    $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $imageAdapter = $this->adapterFactory->create();
                    $uploaderFactory->addValidateCallback('custom_image_upload', $imageAdapter, 'validateUploadFile');
                    $uploaderFactory->setAllowRenameFiles(true);//false
                    $uploaderFactory->setFilesDispersion(true);//hz false
                    $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                    $destinationPath = $mediaDirectory->getAbsolutePath('customer');  //customermy
                    $result = $uploaderFactory->save($destinationPath);
                    $customer = $this->currentCustomer->getCustomer();
                    $this->mediaCustomerPath->setPicture($customer, $result['file']);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
        }
        return $resultRedirect->setPath('*/*/', ['_current' => true]);
    }
}
