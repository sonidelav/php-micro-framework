<?php

namespace App\IMNOSLib\UserControls;

class DatefieldControl extends UserControl
{
    public function __construct($config = [])
    {
        $config = array_merge($config, ['ctrltype' => 'datefield']);
        parent::__construct($config);
    }
}