<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 03.
 * Time: 13:29
 */

namespace MedevAuth\Token\JWT\JWS;

use MedevAuth\Token\JWT\JWTConfiguration;

abstract class JWSConfiguration implements JWTConfiguration
{
    private $privateKey;
    private $publicKey;

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function setPrivateKey($pathToKey)
    {
        $this->privateKey = $pathToKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function setPublicKey($pathToKey)
    {
        $this->publicKey = $pathToKey;
    }

}