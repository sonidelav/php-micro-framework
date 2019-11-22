<?php

namespace App\Base;

use Lime\App as LimeApplication;

use App\Controllers\FrontController;
use App\IMNOSLib\Helpers\MarketsList;
use App\IMNOSLib\Helpers\TagValues;

class MicroApplication extends LimeApplication
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
            'helpers'      => [
                'TagValues'   => new TagValues($this),
                'MarketsList' => new MarketsList($this),
                'HttpClient'  => new HttpClient(),
            ],
        ], $settings));

        if (in_array('database', array_keys($settings)))
        {
            // Database
            $this->db = new DatabaseConnection($settings[ 'database' ]);
        }

        $front = new FrontController($this);
        $this->bind('/', [ $front, 'index' ]);
    }

    /**
     * @return \Medoo\Medoo|null
     */
    public function getDb()
    {
        return $this->db ? $this->db->getDb() : null;
    }

    /**
     * @return TagValues
     */
    public function tagValues()
    {
        return $this->helper('TagValues');
    }

    /**
     * @return MarketsList
     */
    public function marketsList()
    {
        return $this->helper('MarketList');
    }

    /**
     * @return HttpClient
     */
    public function httpClient()
    {
        return $this->helper('HttpClient');
    }
}
