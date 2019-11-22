<?php

namespace ImnosReports\GeneralDegradation\Service;

require_once __DIR__.'/../tableView.php';

use ImnosReports\GeneralDegradation\Classes\Application;

class ReportService
{
    /** @var Application */
    private $app;

    /** @var KPIDrService */
    private $kpiService;

    private $columns = [
        "traffic"     => "Traffic(Erl)",
        "traffic_avg" => "Traffic Degradation(%)",
        "afr"         => "Volte AFR (GCR)(%)",
        "afr_avg"     => "Volte AFR Degradation(GCR)(%)",
        "dcr"         => "Volte DCR (GCR)(%)",
        "dcr_avg"     => "Volte DCR Degradation(GCR)(%)",
    ];

    public function __construct(Application $app)
    {
        $this->app        = $app;
        $this->kpiService = new KPIDrService($app);
    }

    protected function show($data)
    {
        return (float)$data->traffic_avg > 10 ||
            ( 0.5 <= (float)$data->afr && (float)$data->afr < 1 && (float)$data->afr_avg > 50 ) ||
            ( (float)$data->afr > 1 && (float)$data->afr_avg > 20 ) ||
            ( 0.5 <= (float)$data->dcr && (float)$data->dcr < 1 && (float)$data->dcr_avg > 50 ) ||
            ( (float)$data->dcr > 1 && (float)$data->dcr_avg > 20 );
    }

    protected function showByBehavior($data, $behavior)
    {
        if ($behavior == '1') // Ignore Empty First Day
        {
            $ret =
                $data->traffic == "-" &&
                $data->afr == "-" &&
                $data->dcr == "-" &&
                $data->traffic_avg == "-" &&
                $data->afr_avg == "-" &&
                $data->dcr_avg == "-";
            return !$ret;
        }

        return true;
    }

    protected function showValue($data, $key)
    {
        if (empty($data))
            return "";

        $date = date("Y-m-d", strtotime($data->date));

        if (isset($data->latest_check_out))
        {
            $latest_check_out = date("Y-m-d", strtotime($data->latest_check_out));

            if (strtotime($date) == strtotime($latest_check_out))
            {
                return "Check Out";
            }
            elseif (strtotime($date) < strtotime($latest_check_out))
            {
                return "";
            }
        }
        elseif (isset($data->latest_unlock))
        {
            $latest_unlock = date("Y-m-d", strtotime($data->latest_unlock));

            if (strtotime($date) == strtotime($latest_unlock))
            {
                return "Unlocked";
            }
            elseif (strtotime($date) < strtotime($latest_unlock))
            {
                return "";
            }
        }

        // Show "-" for "-". It's not a number
        if ($data->{$key} == "-") return "-";

        // Format numbers with 2 decimal digits.
        return number_format($data->{$key}, 2);
    }

    protected function calculateDegradation(&$d, $date)
    {
        // calculating  Degradation percentage
        // For the KPIs that are included at this moment in the General Degradation Report there is degradation if:
        // Traffic(Erl) is reduced.
        // Volte AFR(GCR)% is increased.
        // Volte DCR(GCR)% is increased.

        $d[ 'dates' ][ $date ]->traffic_avg = 100 * ( $d[ 'dates' ][ $date ]->traffic_avg - $d[ 'dates' ][ $date ]->traffic ) / $d[ 'dates' ][ $date ]->traffic_avg;
        $d[ 'dates' ][ $date ]->afr_avg     = 100 * ( $d[ 'dates' ][ $date ]->afr_avg - $d[ 'dates' ][ $date ]->afr ) / $d[ 'dates' ][ $date ]->afr_avg;
        $d[ 'dates' ][ $date ]->dcr_avg     = 100 * ( $d[ 'dates' ][ $date ]->dcr_avg - $d[ 'dates' ][ $date ]->dcr ) / $d[ 'dates' ][ $date ]->dcr_avg;

        // We keep only positive Traffic-Degradation. For negative Traffic-degradation we print “-”.
        if ((float)$d[ 'dates' ][ $date ]->traffic_avg <= 0)
        {
            $d[ 'dates' ][ $date ]->traffic_avg = "-";
            $d[ 'dates' ][ $date ]->traffic     = "-";
        }
        // We keep only negative AFR-Degradation and print the absolute value. For positive AFR-degradation we print “-”.
        if ((float)$d[ 'dates' ][ $date ]->afr_avg >= 0)
        {
            $d[ 'dates' ][ $date ]->afr_avg = "-";
            $d[ 'dates' ][ $date ]->afr     = "-";

        }
        else
        {
            $d[ 'dates' ][ $date ]->afr_avg = abs((float)$d[ 'dates' ][ $date ]->afr_avg);
        }
        // We keep only negative DCR-Degradation and print the absolute value. For positive DCR-degradation we print “-”.
        if ((float)$d[ 'dates' ][ $date ]->dcr_avg >= 0)
        {
            $d[ 'dates' ][ $date ]->dcr_avg = "-";
            $d[ 'dates' ][ $date ]->dcr     = "-";
        }
        else
        {
            $d[ 'dates' ][ $date ]->dcr_avg = abs((float)$d[ 'dates' ][ $date ]->dcr_avg);
        }
    }

    protected function prepareDataForView(&$d, $dates)
    {
        foreach ($dates as $k => $date)
        {
            $this->calculateDegradation($d, $date);
            foreach ($this->columns as $key => $value)
            {
                $d[ 'dates' ][ $date ]->{$key} = $this->showValue($d[ 'dates' ][ $date ], $key);
            }
        }
    }

    /**
     * @param $market
     * @param $data
     * @param $initDate
     * @param $behavior
     * @return mixed
     */
    protected function generateTableForMarket($market, $data, $initDate, $behavior)
    {
        $dates = [];
        for ($i = 0; $i < 4; $i++)
        {
            $dates[] = date("Y-m-d", strtotime($initDate . " -$i days"));
        }

        $sites = [];
        foreach ($data->sites as $key => $val)
        {
            $sites[ $val->site_id ] = $val;
        }

        $htmlData = [];
        foreach($data->data as $data)
        {
            $site_with_tech         = $this->app->techHelper()->convertSiteId($data->site, $data->technology);

            $data->latest_unlock 	= $sites[$site_with_tech] ? $sites[$site_with_tech]->latest_unlock : null;
            $data->latest_check_out = $sites[$site_with_tech] ? $sites[$site_with_tech]->latest_check_out : null;
            $htmlData[$data->site.$data->sector]["site"] 				= $data->site;
            $htmlData[$data->site.$data->sector]["sector"] 				= $data->sector;
            $htmlData[$data->site.$data->sector]["activity_type"] 		= $sites[$site_with_tech] ? $sites[$site_with_tech]->type : "N/A";
            $htmlData[$data->site.$data->sector]["sub_activity_type"] 	= $sites[$site_with_tech] ? $sites[$site_with_tech]->sub_activity_type : "N/A";
            $htmlData[$data->site.$data->sector]["technology"] 			= $data->technology;
            $htmlData[$data->site.$data->sector]["dates"][$data->date] 	= $data;
        }

        // TODO: add feature into compiler to embeds require php view files
    }

    public function generateReports($marketList, $initialDate, $behavior)
    {
        $tables = [];
        foreach ($marketList as $market)
        {
            $data     = $this->kpiService->getDataFromAPI($initialDate, $market);
            $tables[] = $this->generateTableForMarket($market, $data, $initialDate, $behavior);
        }

        return renderTable(null);
    }
}