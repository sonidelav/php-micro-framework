<?php
namespace App\IMNOSLib\Helpers;

use Framework\Helper;

class MarketsList extends Helper
{
    private $list = [
        "laa" => ["value" => "LAA",  "text" => "Los Angeles",         "timezone" => "America/Los_Angeles",  "ip" => "10.159.121.223", "db" => "imnosrf-db-04"],
        "ut"  => ["value" => "UT",   "text" => "Salt Lake City (Uta)","timezone" => "America/Denver",       "ip" => "10.135.97.25",   "db" => "imnosrf-db-10"],
        "vg"  => ["value" => "VG",   "text" => "Las Vegas",           "timezone" => "America/Los_Angeles",  "ip" => "10.135.97.24",   "db" => "imnosrf-db-12"],
        "sc"  => ["value" => "SC",   "text" => "Sacramento",          "timezone" => "America/Los_Angeles",  "ip" => "10.135.97.20",   "db" => "imnosrf-db-15"],
        "sf"  => ["value" => "SF",   "text" => "San Fransisco",       "timezone" => "America/Los_Angeles",  "ip" => "10.135.97.22",   "db" => "imnosrf-db-14"],
        "sd"  => ["value" => "SD",   "text" => "San Diego",           "timezone" => "America/Los_Angeles",  "ip" => "10.135.97.23",   "db" => "imnosrf-db-08"],
        "au"  => ["value" => "AU",   "text" => "Austin",              "timezone" => "America/Chicago",      "ip" => "10.135.97.19",   "db" => "imnosrf-db-11"],
        "da"  => ["value" => "DA",   "text" => "Dallas",              "timezone" => "America/Chicago",      "ip" => "10.159.121.209", "db" => "imnosrf-db-05"],
        "hn"  => ["value" => "HN",   "text" => "Houston",             "timezone" => "America/Chicago",      "ip" => "10.159.121.208", "db" => "imnosrf-db-03"],
        "pts" => ["value" => "PTS",  "text" => "Portland",            "timezone" => "America/Los_Angeles",  "ip" => "10.135.97.21",   "db" => "imnosrf-db-07"],
        "hi"  => ["value" => "HI",   "text" => "Hawaii",              "timezone" => "Pacific/Honolulu",     "ip" => "10.135.97.21",   "db" => "imnosrf-db-07"],
        "se"  => ["value" => "SE",   "text" => "Seattle",             "timezone" => "America/Los_Angeles",  "ip" => "10.159.121.209", "db" => "imnosrf-db-05"],
        "cr"  => ["value" => "CR",   "text" => "Carolina",            "timezone" => "America/Puerto_Rico",  "ip" => "10.135.97.17",   "db" => "imnosrf-db-09"],
        "nyc" => ["value" => "NYC",  "text" => "New York",            "timezone" => "America/New_York",     "ip" => "10.159.121.208", "db" => "imnosrf-db-03"],
        "dc"  => ["value" => "DC",   "text" => "Washington DC",       "timezone" => "America/New_York",     "ip" => "10.135.97.17",   "db" => "imnosrf-db-02"],
        "ph"  => ["value" => "PEN",  "text" => "Philadelphia",        "timezone" => "America/New_York",     "ip" => "10.135.97.22",   "db" => "imnosrf-db-06"],
        "nj"  => ["value" => "nyc",  "text" => "New Jersey",          "timezone" => "America/New_York",     "ip" => "10.159.121.208", "db" => "imnosrf-db-03"],
        //    "dc"  => ["value" => "DC",   "text" => "Washington DC",       "timezone" => "America/New_York",     "ip" => "10.159.121.194", "db" => "imnosrf-db-02"],
        //    "ph"  => ["value" => "PEN",   "text" => "Philadelphia",       "timezone" => "America/New_York",     "ip" => "10.159.121.236", "db" => "imnosrf-db-06"],
    ];

    /**
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @return array
     */
    public function toDataSource()
    {
        return array_values($this->list);
    }
}