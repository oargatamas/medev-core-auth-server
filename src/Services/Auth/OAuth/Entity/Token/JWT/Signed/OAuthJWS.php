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
     * @return bool
     */
    public function verifySignature($publicKey)
    {
        $token = new JOSE_JWS($this->mapPropsToClaims());
        try {
            $token->verify($publicKey, "RS256");
            return true;
        } catch (\JOSE_Exception_VerificationFailed $e) {
            return false;
        }
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