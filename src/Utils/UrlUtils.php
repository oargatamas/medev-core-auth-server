<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 08.
 * Time: 9:00
 */

namespace MedevAuth\Utils;


class UrlUtils
{
    public static function getTopLevelDomain($domainString){
        $hostParts = explode('.', $domainString);
        $hostParts = array_reverse($hostParts);
        $host = $hostParts[1] . '.' . $hostParts[0];

        return $host;
    }
}