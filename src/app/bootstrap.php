<?php

namespace {

    use App\Base\MicroApplication;

    $app = new MicroApplication([
        'debug'        => true,
        'app.name'     => 'Micro Application',
        'session.name' => 'microsession',
        'charset'      => 'UTF-8',

        'database' => [
            'database_type' => 'mysql',
            'database_name' => 'ti_db',
            'server'        => '127.0.0.1',
            'username'      => 'root',
            'password'      => 'root',
        ],
    ]);

    $app->run();
}
