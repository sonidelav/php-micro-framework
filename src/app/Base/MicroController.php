<?php

namespace App\Base;

class MicroController
{
    /** @var MicroApplication */
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }
}