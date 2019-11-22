<?php

namespace App\Base;

abstract class MicroController
{
    /** @var MicroApplication */
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function index()
    {
        if($this->app->tagValues()->isExist())
            return $this->reportResponse();
        else
            return $this->popupResponse();
    }

    protected abstract function reportResponse();
    protected abstract function popupResponse();
}