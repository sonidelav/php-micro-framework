<?php

namespace App\IMNOSLib\Helpers;

use Lime\Helper;

class TagValues extends Helper
{
    private $data = null;

    public function initialize()
    {
        $tagValues = $this->app->param('tagvalues');
        if($tagValues)
        {
            $this->data = $this->app->json()->decode($tagValues, false);
        }
    }

    public function hasProperty($key)
    {
        return $this->data ? isset($this->data->$key) : false;
    }

    public function getProperty($key, $default = null)
    {
        return $this->hasProperty($key) ? $this->data->$key : $default;
    }

    public function isExist()
    {
        return $this->data !== null ? true : false;
    }
}