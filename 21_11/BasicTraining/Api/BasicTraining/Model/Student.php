<?php
namespace Cowell\BasicTraining\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\AbstractModel;
use Cowell\BasicTraining\Model\ResourceModel\Student as ResourceModel;

class Student extends AbstractExtensibleModel implements \Cowell\BasicTraining\Api\Data\StudentInterface
{
    const CACHE_TAG = 'students';

    protected $_cacheTag = 'students';

    protected $_eventPrefix = 'students';
    protected function _construct()
    {
        $this->_init('Cowell\BasicTraining\Model\ResourceModel\Student');
    }
    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getDob()
    {
        return $this->getData(self::DOB);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    public function getCreateAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdateAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setDob($dob)
    {
        return $this->setData(self::DOB, $dob);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    public function setCreateAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdateAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cowell\BasicTraining\Api\Data\StudentExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cowell\BasicTraining\Api\Data\StudentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cowell\BasicTraining\Api\Data\StudentExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
