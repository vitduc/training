<?php

namespace Cowell\BasicTraining\Api\Data;

interface StudentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const DOB = 'dob';
    const NAME = 'name';
    const GENDER = 'gender';
    const IMAGE = 'image';
    const ADDRESS = 'address';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return string|null
     */
    public function getDob();

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getImage();

    /**
     * @return string|null
     */
    public function getAddress();

    /**
     * @return string|null
     */
    public function getCreateAt();

    /**
     * @return string|null
     */
    public function getUpdateAt();

    /**
     * @param $id
     * @return StudentInterface
     */
    public function setId($id);

    /**
     * @param $dob
     * @return StudentInterface
     */
    public function setDob($dob);

    /**
     * @param $name
     * @return StudentInterface
     */
    public function setName($name);

    /**
     * @param $image
     * @return StudentInterface
     */
    public function setImage($image);

    /**
     * @param $address
     * @return StudentInterface
     */
    public function setAddress($address);

    /**
     * @param $createdAt
     * @return StudentInterface
     */
    public function setCreateAt($createdAt);

    /**
     * @param $updatedAt
     * @return StudentInterface
     */
    public function setUpdateAt($updatedAt);
    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cowell\BasicTraining\Api\Data\StudentExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cowell\BasicTraining\Api\Data\StudentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cowell\BasicTraining\Api\Data\StudentExtensionInterface $extensionAttributes
    );
}
