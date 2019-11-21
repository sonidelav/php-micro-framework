<?php

namespace App\Base;

class Collection
{
    private $data = [];

    public function addItem($item)
    {
        $this->data[] = $item;
    }

    public function toJSON()
    {
        return json_encode($this->data);
    }

    public function toArray()
    {
        return $this->data;
    }
}