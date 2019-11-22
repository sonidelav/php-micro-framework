<?php

namespace App\IMNOSLib\Helpers;

use Lime\Helper;

class TechHelper extends Helper
{
    private $techPrefixes = [
        "UMTS" => [ "U", "P" ],
        "LTE"  => [ "L", "B", "C", "D", "E", "F", "G" ],
        "GSM"  => [ "G" ],
        ''     => '',
    ];

    private $techSuffixes = [
        "UMTS" => [ "", "2", "3", "4", "5" ],
        "LTE"  => [ "", "2", "3", "4", "5" ],
        "GSM"  => [ "" ],
        ''     => '',
    ];

    public function convertSiteId($siteId, $tech)
    {
        $tech_prefix_mapping = $this->techPrefixes;
        $tech_suffix_mapping = $this->techSuffixes;

        $tech             = strtoupper($tech);
        $site_firstLetter = substr($siteId, 0, 1);
        $site_lastLetter  = substr($siteId, -1, 1);


        // GET TECH SUFFIX and PREFIX
        $techPrefixes = isset($tech_prefix_mapping[ $tech ]) ? $tech_prefix_mapping[ $tech ] : [];
        $techSuffixes = isset($tech_suffix_mapping[ $tech ]) ? $tech_suffix_mapping[ $tech ] : [];

        // MAKE AN ARRAY FROM STRING
        $result = str_split($siteId);

        // REMOVE PREFIX
        if (in_array(strtoupper($site_firstLetter), $techPrefixes))
        {
            unset($result[ 0 ]);
        }
        // REMOVE SUFFIX
        if (in_array(strtoupper($site_lastLetter), $techSuffixes))
        {
            unset($result[ count($result) - 1 ]);
        }

        // RETURN CONVERTED SITE
        return implode('', $result);
    }
}