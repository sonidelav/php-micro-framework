<?php

namespace ImnosReports\GeneralDegradation\Classes;

use App\Base\MicroApplication;

class Application extends MicroApplication
{
    public function __construct()
    {
        $settings = [
            'debug'           => true,
            'app.name'        => 'IMNOS Reports - General Degradation',
            'session.name'    => 'imnos-tts-gd',
            'charset'         => 'UTF-8',
            'frontController' => FrontController::class

            //        'database' => [
            //            'database_type' => 'mysql',
            //            'database_name' => 'ti_db',
            //            'server'        => '127.0.0.1',
            //            'username'      => 'root',
            //            'password'      => 'root',
            //        ],
        ];

        parent::__construct($settings);
    }
}