<?php

namespace Cowell\BasicTraining\Cron;

use Cowell\BasicTraining\Model\ResourceModel\Student\CollectionFactory;
use Magento\Framework\App\State;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Test
{
    protected $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory     $collectionFactory,
        Timezone              $date,
        StoreManagerInterface $storeManager,
        StateInterface        $inlineTranslation,
        TransportBuilder      $transportBuilder,
        State                 $state,
        LoggerInterface       $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->date = $date;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->state = $state;
        $this->logger = $logger;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $collection = $this->collectionFactory->create()->addFieldToFilter('dob', ['like'=> '%' . $this->getDate() . '%']);
        foreach ($collection as $user) {
            $templateOptions = ['area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $this->storeManager->getStore()->getId()];
            $templateVars = [
                'store' => $this->storeManager->getStore(),
                'customer_name' => $user->getName(),
                'message' => 'Happy birth day'
            ];
            $from = ['email' => "ducnv@co-well.vn", 'name' => 'Name of Sender'];
            $this->inlineTranslation->suspend();
            $to = [$user->getEmail()];
            $transport = $this->transportBuilder->setTemplateIdentifier('auriga_custom_email_template')
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($from)
                ->addTo($to)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        }
    }
    public function getDate()
    {
        return $this->date->date()->format('m-d');
    }
}
