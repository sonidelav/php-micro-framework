<?php

namespace Builder\Commands;

use Builder\BuilderConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompileCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:compile')
            ->addOption('bootstrap', null, InputOption::VALUE_REQUIRED, 'Bootstrap filepath')
            ->addOption('output', null, InputOption::VALUE_OPTIONAL, 'Output filename', 'app.php')
            ->setDescription('Compile Application to a Single PHP File');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputPreloadFilepath = __DIR__ . '/../../../dist/preload.php';
        $outputDirectoryPath   = __DIR__ . '/../../../dist';

        $bootstrapFilepath = $input->getOption('bootstrap');
        $outputFilename    = $input->getOption('output');

        if (!$bootstrapFilepath)
            throw new \Exception('Bootstrap Missing');

        $builderConfig = new BuilderConfig();
        $builderConfig->setBootstrap($bootstrapFilepath);
        $builderConfig->compile();

        $command       = $this->getApplication()->find('preloader:compile');
        $args           = [
            'command'          => 'preloader:compile',
            '--config'         => $builderConfig->getConfig(),
            '--output'         => $outputPreloadFilepath,
            '--fix_dir'        => false,
            '--fix_file'       => false,
            '--strip_comments' => true,
        ];
        $preloaderInput = new ArrayInput($args);
        $command->run($preloaderInput, $output);

        // Get Preload Contents
        $preloadContents = file_get_contents($outputPreloadFilepath);
        unlink($outputPreloadFilepath);

        // Get Bootstrap Contents
        $executableContents = file_get_contents($bootstrapFilepath);

        // Remove PHP Tags
        /* $preloadContents    = str_replace([ '<?php', '?>' ], '', $preloadContents); */
        /* $executableContents = str_replace([ '<?php', '?>' ], '', $executableContents); */

        // Combine into one
        $appContents = '<?php ' . "\n/* THIS CODE IS AUTO GENERATED */\n ?>" . $preloadContents . '?>' . $executableContents . '?>';
        file_put_contents($outputDirectoryPath . '/' . $outputFilename, $appContents);

        // Done
        $output->writeln('---');
        $output->writeln("Compiled Successfully");
    }
}
