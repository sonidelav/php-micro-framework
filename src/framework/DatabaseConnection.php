<?php

namespace Framework;

use Medoo\Medoo;

class DatabaseConnection
{
    /** @var Medoo */
    private $dbInstance;
    
    public function __construct($options = [])
    {
        $this->dbInstance = new Medoo($options);
    }
    
    public function getDb()
    {
        return $this->dbInstance;
    }
}
