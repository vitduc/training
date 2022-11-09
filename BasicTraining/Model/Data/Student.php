<?php

namespace Cowell\BasicTraining\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;

class Student extends AbstractExtensibleObject implements \Cowell\BasicTraining\Api\Data\StudentInterface
{
    public function getId()
    {
        return $this->_get(self::ID);
    }

    public function getDob()
    {
        return $this->_get(self::DOB);
    }

    public function getName()
    {
        return $this->_get(self::NAME);
    }

    public function getImage()
    {
        return $this->_get(self::IMAGE);
    }

    public function getCreateAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    public function getUpdateAt()
    {
        return $this->_get(self::UPDATED_AT);
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
        return $this->_get(self::ADDRESS);
    }

    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }
}
