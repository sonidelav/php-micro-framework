<?php

namespace App\Controllers;

use App\Base\Collection;
use App\Base\MicroController;
use App\IMNOSLib\ReportItems\HTMLReportItem;
use App\IMNOSLib\UserControls\MultiselectControl;

class FrontController extends MicroController
{
    public function index()
    {
        if ($this->app->tagValues()->isExist())
        {
            // Run Process
            return 'TODO: Run Process';
        }
        else
        {
            // Output User Controls
            return $this->getUserInputResponse();
        }
    }

    protected function getUserInputResponse()
    {
        $userControls = new Collection();
        $reportItems  = new Collection();

        $userControls->addItem(
            // Multiselect Control
            new MultiselectControl([
                'ctrlKey'       => 'market_list',
                'emptyText'     => 'Select Markets',
                'label'         => 'Market List',
                'displayField'  => 'text',
                'valueField'    => 'value',
                'allowBlank'    => false,
                'defaultValue'  => '',
                'fields'        => [ 'text', 'value' ],
                'height'        => 200,
                'minSelections' => 1,
                'maxSelections' => 100,
                'data'          => [],
            ])
        );

        $reportItems->addItem(
            // HTML Report Item
            new HTMLReportItem([
                'title'     => 'HTML MODULE',
                'width'     => 1000,
                'height'    => 400,
                'backcolor' => '#FFFFFF',
                'html'      => '',
            ])
        );

        return [
            'userinput' => $userControls->toArray(),
            'reports'   => $reportItems->toArray(),
            'submit'    => 1,
        ];
    }
}
