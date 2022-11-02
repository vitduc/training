<?php

namespace Cowell\BasicTraining\Model\Student;

use Magento\Framework\UrlInterface;
use Magento\Framework\Filesystem;

class Image
{
    /**
     * media sub folder
     * @var string
     */
    protected $subDir = 'catalog/tmp/category'; //actual path is pub/media/Vendor/image
    //http://127.0.0.1/magento4/pub/media/extension/tmp/post/myimage.png
    /**
     * url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $fileSystem;
    /**
     * @param UrlInterface $urlBuilder
     * @param Filesystem $fileSystem
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem $fileSystem
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
    }
    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir . '/';
    }
}
