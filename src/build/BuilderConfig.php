<?php

namespace Builder;

class BuilderConfig
{
    private $vendorAutoloaderPath;
    private $bootstrapPath;

    /** @var BuilderLoader */
    private $loader;

    private $includedFiles = [];

    public function __construct()
    {
        $this->vendorAutoloaderPath = __DIR__ . '/../../vendor/autoload.php';
        $this->loader               = new BuilderLoader();
    }

    public function setBootstrap($path)
    {
        $this->bootstrapPath = $path;
    }

    public function compile()
    {
        require_once( $this->vendorAutoloaderPath );
        $this->loader->register();

        $beforeIncluded = get_included_files();
        require_once( $this->bootstrapPath );
        $afterIncluded = get_included_files();

        $this->loader->unregister();

        foreach ($afterIncluded as $key => $filepath)
        {
            if (in_array($filepath, $beforeIncluded))
                unset($afterIncluded[ $key ]);
        }

        $this->includedFiles = $afterIncluded;
    }

    public function getConfig()
    {
        $classFiles = $this->loader->getFilenames();
        $files      = array_merge($classFiles, $this->includedFiles);
        $files      = array_unique($files);

        return implode(',', $files);
    }
}