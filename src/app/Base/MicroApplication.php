<?php

namespace App\Base;

use App\Controllers\FrontController;
use Framework\Application;
use Framework\DatabaseConnection;

class MicroApplication extends Application
{
    /** @var DatabaseConnection|null */
    private $db = null;
    
    public function __construct($settings = [])
    {
        parent::__construct(array_merge([
            'debug'        => true,
            'app.name'     => 'Micro Application',
            'session.name' => 'microsession',
            'charset'      => 'UTF-8',
            
            //'autoload'     => new \ArrayObject([]),
            //'sec-key'      => 'xxxxx-SiteSecKeyPleaseChangeMe-xxxxx',
            //'route'        => $_SERVER['PATH_INFO'] ?? '/',
            //'helpers'      => [],
            //'base_url'     => $base_url,
            //'base_route'   => $base_url,
            //'base_host'    => $_SERVER['SERVER_NAME'] ?? php_uname('n'),
            //'base_port'    => $_SERVER['SERVER_PORT'] ?? 80,
            //'docs_root'    => null,
            //'site_url'     => null
        ], $settings));
        
        // Database
        $this->db = new DatabaseConnection([
            'database_type' => 'mysql',
            'database_name' => 'nerp_database',
            'server'        => '127.0.0.1',
            'username'      => 'root',
            'password'      => ''
        ]);
        
        $front = new FrontController($this);
        
        $this->bind('/', [$front, 'index']);
    }
    
    /**
     * @return \Medoo\Medoo|null
     */
    public function getDb()
    {
        return $this->db ? $this->db->getDb() : null;
    }
}
