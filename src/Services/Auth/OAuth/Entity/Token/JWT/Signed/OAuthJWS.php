<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 16.
 * Time: 10:15
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed;


use JOSE_JWS;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\OAuthJWT;

class OAuthJWS extends OAuthJWT
{
    /**
     * @var string
     */
    private $privateKey;


    /**
     * @param string $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @param string $publicKey
     * @throws \JOSE_Exception_VerificationFailed
     */
    public function verifySignature($publicKey){
        $token = new JOSE_JWS($this->mapPropsToClaims());
        $token->verify($publicKey,"RS256");
    }

    /**
     * @return string
     * @throws \JOSE_Exception
     */
    public function finalizeToken()
    {
        $token = (new JOSE_JWS($this->mapPropsToClaims()));

        return $token->sign($this->privateKey, "RS256")->toString();
    }


}