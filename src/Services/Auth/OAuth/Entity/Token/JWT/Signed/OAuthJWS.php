<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 16.
 * Time: 10:15
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed;



use JOSE_Exception_VerificationFailed;
use JOSE_JWT;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\OAuthJWT;
use phpseclib\Crypt\RSA;

class OAuthJWS extends OAuthJWT
{
    /**
     * @var RSA
     */
    protected $signingKey;
    /**
     * @var RSA
     */
    protected $verificationKey;


    public function __construct(JOSE_JWT $jwt, RSA $privateKey, RSA $publicKey)
    {
        $this->signingKey = $privateKey;
        $this->verificationKey = $publicKey;
        parent::__construct($jwt);
    }

    /**
     * @return bool
     */
    public function verifySignature()
    {
        try {
            $this->jwt->verify($this->verificationKey, "RS256");
            return true;
        } catch (JOSE_Exception_VerificationFailed $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function finalizeToken()
    {
        return $this->jwt->sign($this->signingKey, "RS256")->toString();
    }


}