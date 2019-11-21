<?php

namespace App\IMNOSLib\UserControls;

use App\Base\MicroConfigObject;

/**
 * Base Class of IMNOS UserControl
 * @package App\IMNOSLib\UserControls
 */
class UserControl extends MicroConfigObject
{
    public $ctrltype;
    public $ctrlKey;
    public $emptyText;
    public $label;
    public $allowBlank;
    public $defaultValue;
}