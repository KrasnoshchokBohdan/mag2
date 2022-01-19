<?php

namespace City\Definition\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandExample extends Command
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('ps:cs:example');
        $this->setDescription('example');
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        // todo: implement CLI command logic here
    }
}
