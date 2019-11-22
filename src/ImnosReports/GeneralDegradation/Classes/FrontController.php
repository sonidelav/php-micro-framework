<?php

namespace ImnosReports\GeneralDegradation\Classes;

use App\Base\MicroController;

class FrontController extends MicroController
{
    public function index($params)
    {
        return 'Hello From General Degradation Report';
    }
}