<?php
namespace Cowell\BasicTraining\Block;

use Magento\Framework\View\Element\Template;

class Student extends Template
{

    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pageConfig->getTitle()->set(__('Students List'));
    }


}
