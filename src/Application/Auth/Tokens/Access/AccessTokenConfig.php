<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 12:11
 */

namespace MedevAuth\Application\Auth\Tokens\Access;


use MedevAuth\Token\JWT\JWS\JWSConfiguration;
use MedevSlim\Utils\UUID\UUID;

class AccessTokenConfig extends JWSConfiguration
{


    public function __construct($publicKey,$privateKey,$passPhrase = "")
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->passPhrase = $passPhrase;
    }



    public function getISS()
    {
        return "https://suite.medev.hu";
    }

    public function getSUB()
    {
        return "Suite API Access";
    }

    public function getAUD()
    {
        return "https://api.suite.medev.hu";
    }

    public function getEXP()
    {
        return time() + 300000; // 5 minutes
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
        return UUID::v5(UUID::NAMESPACE_URL,"auth.suite.medev.hu/access_token");
    }
}