<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 04.
 * Time: 15:27
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\Encrypted;


use JOSE_JWT;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use phpseclib\Crypt\RSA;

class OAuthJWSE extends OAuthJWS
{
    /**
     * @var RSA
     */
    protected $publicKey;

    /**
     * @param RSA $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    public function finalizeToken()
    {
        $token = new JOSE_JWT($this->mapPropsToClaims());

        return $token
            ->sign($this->privateKey,"RS256")
            ->encrypt($this->publicKey,"RS256")
            ->toString();
    }
}