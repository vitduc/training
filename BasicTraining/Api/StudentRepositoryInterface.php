<?php

declare(strict_types=1);

namespace Cowell\BasicTraining\Api;

interface StudentRepositoryInterface
{

    /**
     * Save Student
     * @param \Cowell\BasicTraining\Api\Data\StudentInterface $student
     * @return \Cowell\BasicTraining\Api\Data\StudentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Cowell\BasicTraining\Api\Data\StudentInterface $student
    );

    /**
     * Retrieve Student
     * @param string $studentId
     * @return \Cowell\BasicTraining\Api\Data\StudentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($studentId);

    /**
     * Retrieve Student matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cowell\BasicTraining\Api\Data\StudentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Student
     * @param \Cowell\BasicTraining\Api\Data\StudentInterface $student
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Cowell\BasicTraining\Api\Data\StudentInterface $student
    );

    /**
     * Delete Student by ID
     * @param string $studentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($studentId);
}
