<?php

namespace City\Definition\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use City\Definition\Service\Npcity;
use Zend_Http_Client_Exception;

class ImportCommand extends Command
{

    /**
     * @var Npcity
     */
    private Npcity $npCity;

    /**
     * @param Npcity $npCity
     * @param string|null $name
     */
    public function __construct(
        Npcity $npCity,
        string $name = null
    ) {
        parent::__construct($name);
        $this->npCity = $npCity;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('np:import');
        $this->setDescription('NP city import.');
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws Zend_Http_Client_Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if ($this->npCity->execute()) {
            $output->writeln('<info>Done!.</info>');
        } else {
            $output->writeln('<error>Error!</error>');
        }
    }
}
