<?php

namespace Cowell\BasicTraining\Api\Data;

interface StudentInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
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
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get date of birth
     *
     * @return string|null In keeping with current security and privacy best practices, be sure you are aware of any
     * potential legal and security risks associated with the storage of customers’ full date of birth
     * (month, day, year) along with other personal identifiers (e.g., full name) before collecting or processing
     * such data.
     */
    public function getDob();

    /**
     * Set date of birth
     *
     * @param string $dob
     * @return $this
     */
    public function setDob($dob);

}
