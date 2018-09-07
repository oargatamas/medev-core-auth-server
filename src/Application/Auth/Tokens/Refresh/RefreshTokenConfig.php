<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 12:11
 */

namespace MedevAuth\Application\Auth\Tokens\Refresh;


use MedevAuth\Token\JWT\JWS\JWSConfiguration;
use MedevSlim\Utils\UUID\UUID;

class RefreshTokenConfig extends JWSConfiguration
{

    public function getISS()
    {
        return "https://suite.medev.hu";
    }

    public function getSUB()
    {
        return "Suite RefreshToken Grant";
    }

    public function getAUD()
    {
        return "https://api.suite.medev.hu";
    }

    public function getEXP()
    {
        return time() + 1800000; // 30 minutes
    }

    public function getNBF()
    {
        return time();
    }

    public function getIAT()
    {
        return time();
    }

    public function getJTI()
    {
        return UUID::v5(UUID::NAMESPACE_URL,"auth.suite.medev.hu/refresh_token");
    }
}