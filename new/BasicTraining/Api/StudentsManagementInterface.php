<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Cowell\BasicTraining\Api;

interface StudentsManagementInterface
{

    /**
     * GET for students api
     * @param string $param
     * @return string
     */
    public function getStudents($param);

    /**
     * POST for students api
     * @param string $param
     * @return string
     */
    public function postStudents($param);

    /**
     * PUT for students api
     * @param string $param
     * @return string
     */
    public function putStudents($param);

    /**
     * DELETE for students api
     * @param string $param
     * @return string
     */
    public function deleteStudents($param);
}
