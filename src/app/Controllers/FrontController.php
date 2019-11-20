<?php

namespace App\Controllers;

use App\Base\MicroApplication;

class FrontController
{
    /** @var MicroApplication */
    protected $app;
    
    public function __construct($app)
    {
        $this->app = $app;
    }
    
    public function index()
    {
        $params = $this->app->param();
        return $params;
    }
}
