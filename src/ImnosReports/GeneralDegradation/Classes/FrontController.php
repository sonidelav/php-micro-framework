<?php

namespace ImnosReports\GeneralDegradation\Classes;

use App\Base\MicroController;
use App\IMNOSLib\UserControls\ComboboxControl;
use App\IMNOSLib\UserControls\DatefieldControl;
use App\IMNOSLib\UserControls\MultiselectControl;
use ImnosReports\GeneralDegradation\Service\KPIDrService;

class FrontController extends MicroController
{
    /** @var KPIDrService */
    private $kpiService;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->kpiService = new KPIDrService($app);
    }

    protected function popupResponse()
    {
        return [
            'userinput' => $this->getUserControls(),
        ];
    }

    protected function reportResponse()
    {
        // If not valid inputs
        if (!$this->app->tagValues()->hasProperty('market_list'))
            return $this->popupResponse();

        // Get Inputs From TagValues
        $behavior    = $this->app->tagValues()->getProperty('behavior', 0);
        $initialDate = $this->app->tagValues()->getProperty('initial_date', date('Y-m-d'));
        $marketList  = $this->app->tagValues()->getProperty('market_list', []);

        // Generate HTML Report for inputs


        // Return HTML Report

    }

    #region USER CONTROLS

    private function getUserControls()
    {
        global $GLOBAL_WEBMARKET;

        return [
            // Market List Control
            new MultiselectControl([
                "ctrlKey"       => "market_list",
                "emptyText"     => "Select Markets",
                "label"         => "Market List",
                "displayField"  => "text",
                "valueField"    => "value",
                "allowBlank"    => false,
                "defaultValue"  => [ strtolower($GLOBAL_WEBMARKET) ],
                "fields"        => [ "text", "value" ],
                "height"        => 200,
                "minSelections" => 1,
                "maxSelections" => 100,
                "data"          => $this->app->marketsList()->toDataSource(),
            ]),
            // Date Field
            new DatefieldControl([
                "ctrlKey"      => "initial_date",
                "emptyText"    => "Select date",
                "label"        => "Initial date",
                "allowBlank"   => false,
                "defaultValue" => "",
            ]),
            // Combo Box
            new ComboboxControl([
                "ctrlKey"      => "behavior",
                "emptyText"    => "Select Behavior",
                "label"        => "Report Behavior",
                "displayField" => "text",
                "valueField"   => "value",
                "allowBlank"   => false,
                "defaultValue" => "0",
                "fields"       => [ "text", "value" ],
                "data"         => [
                    [ "value" => '0', 'text' => "Show All" ],
                    [ "value" => '1', 'text' => 'Ignore Empty First Day' ],
                ],
            ]),
        ];
    }

    #endregion
}