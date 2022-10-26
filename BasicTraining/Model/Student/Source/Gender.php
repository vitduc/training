<?php

namespace Cowell\BasicTraining\Model\Student\Source;

use Cowell\BasicTraining\Model\Student;
use Magento\Framework\Data\OptionSourceInterface;

class Gender implements OptionSourceInterface
{
    /**
     * @var \Magento\Cms\Model\Block
     */
    protected $cmsBlock;

    /**
     * Constructor
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 0,
                'label' => __('Female'),
            ],
            [
                'value' => 1,
                'label' => __('Male'),
            ]
        ];
    }
}
