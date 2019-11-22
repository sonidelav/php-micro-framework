<?php

namespace Builder\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ServeCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:serve')
            ->addOption('prod', null, InputOption::VALUE_NONE, 'Serve Production (dist)')
            ->setDescription('Serve Application with build in server');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mode         = $input->getOption('prod') ? 'prod' : 'dev';
        $logger       = new ConsoleLogger($output);
        $rootFolder   = $mode == 'dev' ? __DIR__ . '/../../../public' : __DIR__ . '/../../../dist';
        $serveProcess = new Process([ 'php', '-S', 'localhost:8000', '-t', $rootFolder, ]);

        $serveProcess->setTimeout(0);

        /** @var ProcessHelper $helper */
        $helper = $this->getHelper('process');

        $output->writeln('Serve @ localhost:8000 ['.$mode.']');
        $helper->run($output, $serveProcess, null, function ($type, $data) use ($logger) {
            if (Process::ERR == $type)
                $logger->error($data);
            else
            {
                echo $data;
                $logger->info($data);
            }
        });
    }
}