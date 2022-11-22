<?php

namespace Cowell\BasicTraining\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Framework\View\Element\Template;

class Detail extends Template
{
    protected $studentFactory;
    protected $request;
    protected $date;

    public function __construct(
        Template\Context $context,
        \Cowell\BasicTraining\Model\StudentRepository $studentInterfaceFactory,
//        \Cowell\BasicTraining\Model\StudentFactory $studentFactory,
        Timezone              $date,
        array $data = []
    ) {
//        $this->studentFactory = $studentFactory;
        $this->studentInterfaceFactory = $studentInterfaceFactory;
        $this->date = $date;
        parent::__construct($context, $data);
        $this->pageConfig->getTitle()->set(__('Students Detail'));
    }

    /**
     * @throws LocalizedException
     */
    public function getStudent()
    {
        $get_id = $this->getRequest()->getParam('id');
        $data = $this->studentInterfaceFactory->get($get_id);
        return $data;
    }

    public function getDate()
    {
        return $this->date->date()->format('m-d');
    }
}
