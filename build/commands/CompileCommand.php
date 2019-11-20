<?php

namespace Builder\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CompileCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:compile')
            ->setDescription('Compile Application to a Single PHP File');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command        = $this->getApplication()->find('preloader:compile');
        $args           = [
            'command'          => 'preloader:compile',
            '--config'         => __DIR__ . '/../config/build-config.php',
            '--output'         => __DIR__ . '/../../dist/preload.php',
            '--fix_dir'        => false,
            '--fix_file'       => false,
            '--strip_comments' => true
        ];
        $preloaderInput = new ArrayInput($args);
        $command->run($preloaderInput, $output);
        
        $preloadContents    = file_get_contents(__DIR__ . '/../../dist/preload.php');
        unlink(__DIR__.'/../../dist/preload.php');
        
        $executableContents = file_get_contents(__DIR__ . '/../../src/App/bootstrap.php');
        
        $preloadContents    = str_replace(['<?php', '?>'], '', $preloadContents);
        $executableContents = str_replace(['<?php', '?>'], '', $executableContents);
        
        $appContents = '<?php ' . $preloadContents . $executableContents;
        file_put_contents(__DIR__ . '/../../dist/app.php', $appContents);
        
        $output->writeln('---');
        $output->writeln("Compiled Successfully");
    }
}
