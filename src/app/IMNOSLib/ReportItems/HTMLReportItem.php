<?php

namespace App\IMNOSLib\ReportItems;


class HTMLReportItem extends ReportItem
{
    public $backcolor;
    public $autofit;
    public $html;

    public function __construct($config = [])
    {
        $config = array_merge($config, ['type' => 'HTML']);
        parent::__construct($config);
    }

    public function setHtml($html)
    {
        $this->html = $html;
    }

    public function appendTo($html)
    {
        $this->html .= $html;
    }
}