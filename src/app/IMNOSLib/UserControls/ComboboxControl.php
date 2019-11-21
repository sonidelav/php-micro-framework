<?php

namespace App\IMNOSLib\UserControls;

class ComboboxControl extends UserControl
{
    public $displayField;
    public $valueField;
    public $fields;
    public $data;

    public function __construct($config = [])
    {
        $config = array_merge($config, ['ctrltype' => 'combobox']);
        parent::__construct($config);
    }
}