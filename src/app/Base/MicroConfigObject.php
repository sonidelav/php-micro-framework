<?php

namespace App\Base;


class MicroConfigObject
{
    public function __construct($config = [])
    {
        $this->setAttributes($config);
    }

    public function setAttributes($array)
    {
        foreach($array as $key => $value)
            $this->$key = $value;

        return $this;
    }
}