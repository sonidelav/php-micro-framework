<?php

namespace App\Controllers;

use App\Base\MicroController;
use App\IMNOSLib\ReportItems\HTMLReportItem;
use App\IMNOSLib\UserControls\MultiselectControl;
use Illuminate\Support\Collection;

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

        $userControls->push(
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
            ]),
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

        $reportItems->push(
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
