<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Cowell\BasicTraining\Model;

class StudentsManagement implements \Cowell\BasicTraining\Api\StudentsManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getStudents($param)
    {
        return 'hello api GET return the $param ' . $param;
    }

    /**
     * {@inheritdoc}
     */
    public function postStudents($param)
    {
        return 'hello api POST return the $param ' . $param;
    }

    /**
     * {@inheritdoc}
     */
    public function putStudents($param)
    {
        return 'hello api PUT return the $param ' . $param;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteStudents($param)
    {
        return 'hello api DELETE return the $param ' . $param;
    }
}
