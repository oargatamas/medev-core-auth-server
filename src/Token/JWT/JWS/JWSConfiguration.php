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
    protected $privateKey;
    protected $publicKey;
    protected $passPhrase;

    public function getPrivateKey()
    {
        return $this->privateKey;
    }


    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getPassPhrase(){
        return $this->passPhrase;
    }
}