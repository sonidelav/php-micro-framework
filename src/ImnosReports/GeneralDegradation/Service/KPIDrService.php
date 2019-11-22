<?php

namespace ImnosReports\GeneralDegradation\Service;

use App\Base\HttpClient;
use ImnosReports\GeneralDegradation\Classes\Application;

class KPIDrService
{
    const API_ENDPOINT = 'http://10.159.121.191/api';

    /** @var Application */
    private $app;
    /** @var HttpClient */
    private $httpClient;

    public function __construct(Application $app)
    {
        $this->httpClient = $app->httpClient();
        $this->app        = $app;
    }

    public function getDataFromAPI($date, $market, $company = 'tmo', $datesToCompare = 4)
    {
        $response = $this->httpClient->get(self::API_ENDPOINT . '/kpi_dr.php', [
            'date'             => $date,
            'market'           => $market,
            'company'          => $company,
            'dates_to_compare' => $datesToCompare,
        ]);

        if($response->getStatusCode() == 200)
        {
            return $response->getObject();
        }

        return null;
    }
}