<?php
require __DIR__ . '/../../vendor/autoload.php';

use Builder\commands\ServeCommand;
use Symfony\Component\Console\Application;

use Builder\Commands\CompileCommand;
use Builder\Commands\PreloaderCompileCommand;

$app = new Application("Builder Console", "v1.0.0");

$app->addCommands([
    new PreloaderCompileCommand(),
    new CompileCommand(),
    new ServeCommand()
]);

return $app;
