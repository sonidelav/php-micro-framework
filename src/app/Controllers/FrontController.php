<?php

namespace App\Controllers;

use App\Base\MicroController;

class FrontController extends MicroController
{
    public function index()
    {
        if( $this->app->tagValues()->isExist() )
        {
            // Run Process
            return 'TODO: Run Process';
        }
        else
        {
            // Output User Controls
            return 'TOOD: Output Controls';
        }
    }
}
