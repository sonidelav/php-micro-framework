<?php

namespace App\Base;

use Appstract\LushHttp\Lush;

/**
 * Class HttpClient
 * @package App\Base
 * @docs https://github.com/tcdent/php-restclient
 */
class HttpClient extends Lush
{
    public function __construct($options = [])
    {
        $baseUrl     = isset($options[ 'baseUrl' ]) ? $options[ 'baseUrl' ] : null;
        $httpOptions = isset($options[ 'options' ]) ? $options[ 'options' ] : [];
        $headers     = isset($options[ 'headers' ]) ? $options[ 'headers' ] : [];

        parent::__construct($baseUrl, $httpOptions, $headers);
    }

    /**
     * @param $url
     * @param array $params
     * @param array $headers
     * @return \Appstract\LushHttp\Response\LushResponse
     */
    public function get($url, $params = [], $headers = [])
    {
        return $this
            ->url($url, $params)
            ->headers($headers)
            ->request('get');
    }

    /**
     * @param $url
     * @param array $params
     * @param array $headers
     * @return \Appstract\LushHttp\Response\LushResponse
     */
    public function post($url, $params = [], $headers = [], $asJson = false)
    {
        $request = $this->url($url, $params)->headers($headers);

        if ($asJson)
            $request->asJson();

        return $request->request('post');
    }
}