<?php

namespace Builder;

require_once __DIR__ . '/../../vendor/classpreloader/classpreloader/src/ClassLoader.php';

use ClassPreloader\ClassLoader;

class BuilderConfig
{
    private $vendorAutoloaderPath;
    private $bootstrapPath;

    /** @var ClassLoader */
    private $loader;

    public function __construct()
    {
        $this->vendorAutoloaderPath = __DIR__.'/../../vendor/autoload.php';
        $this->loader = new ClassLoader();
    }

    public function setBootstrap($path)
    {
        $this->bootstrapPath = $path;
    }

    public function compile()
    {
        require_once($this->vendorAutoloaderPath);
        $this->loader->register();
        require_once($this->bootstrapPath);
        $this->loader->unregister();
    }

    public function getConfig()
    {
        return implode(',', $this->loader->getFilenames());
    }
}