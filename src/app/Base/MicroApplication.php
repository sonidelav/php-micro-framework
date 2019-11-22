<?php

namespace App\Base;

use Lime\App as LimeApplication;

use App\IMNOSLib\Helpers\MarketsList;
use App\IMNOSLib\Helpers\TagValues;

class MicroApplication extends LimeApplication
{
    /** @var DatabaseConnection|null */
    private $db = null;

    public function __construct($settings = [])
    {
        $settings = array_merge([
            'debug'           => true,
            'app.name'        => 'Micro Application',
            'session.name'    => 'microsession',
            'charset'         => 'UTF-8',
            'frontController' => MicroController::class,
            'helpers'         => [
                'TagValues'   => new TagValues($this),
                'MarketsList' => new MarketsList($this),
                'HttpClient'  => new HttpClient(),
            ],
        ], $settings);

        parent::__construct($settings);

        if (in_array('database', array_keys($settings)))
        {
            // Database
            $this->db = new DatabaseConnection($settings[ 'database' ]);
        }

        // Init Front Controller
        if (!in_array('frontController', array_keys($settings)))
            throw new \Exception('frontController must be specified');

        // Init Front Controller
        $className  = $settings[ 'frontController' ];
        $controller = new $className($this);

        $this->bind('/', [ $controller, 'index' ]);
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
