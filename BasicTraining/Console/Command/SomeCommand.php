<?php

namespace Cowell\BasicTraining\Console\Command;

use Cowell\BasicTraining\Model\ResourceModel\Student\CollectionFactory;
use Magento\Framework\App\State;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SomeCommand extends Command
{
    const NAME = 'name';

    protected StoreManagerInterface $storeManager;
    protected StateInterface $inlineTranslation;
    protected TransportBuilder $transportBuilder;
    protected State $state;
    protected $student;
    protected $date;

    public function __construct(
        CollectionFactory     $collectionFactory,
        Timezone              $date,
        StoreManagerInterface $storeManager,
        StateInterface        $inlineTranslation,
        TransportBuilder      $transportBuilder,
        State                 $state,
        string                $name = null
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->date = $date;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->state = $state;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('my:first:command');
        $this->setDescription('This is my first console command.');
        $this->addOption(
            self::NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $collection = $this->collectionFactory->create()->addFieldToFilter('dob', ['like' => '%' . $this->getDate() . '%']);
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        foreach ($collection as $user) {
            $templateOptions = ['area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $this->storeManager->getStore()->getId()];
            $templateVars = [
                'store' => $this->storeManager->getStore(),
                'customer_name' => $user->getName(),
                'message' => 'Happy birth day !.' . $user->getName()
            ];
            $from = ['email' => "Example@gmail.com", 'name' => 'Happy birth day!'];
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
