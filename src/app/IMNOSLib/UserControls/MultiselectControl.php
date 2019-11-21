<?php

namespace App\IMNOSLib\UserControls;

class MultiselectControl extends UserControl
{
    public $valueField;
    public $fields;
    public $height;
    public $minSelections;
    public $maxSelections;
    public $data;

    public function __construct($config = [])
    {
        $config = array_merge($config, ['ctrltype' => 'multiselect']);
        parent::__construct($config);
    }
}