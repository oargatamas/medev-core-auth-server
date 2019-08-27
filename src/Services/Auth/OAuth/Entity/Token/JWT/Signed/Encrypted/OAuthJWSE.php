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
    protected $encryptionKey;
    /**
     * @var RSA
     */
    protected $decryptionKey;

    /**
     * OAuthJWSE constructor.
     * @param JOSE_JWT $jwt
     * @param RSA|null $publicKey
     * @param RSA|null $privateKey
     */
    public function __construct(JOSE_JWT $jwt, RSA $publicKey = null, RSA $privateKey = null)
    {
        $this->encryptionKey = $publicKey;
        $this->decryptionKey = $privateKey;
        parent::__construct($jwt,$publicKey,$privateKey);
    }


    public function finalizeToken()
    {
        return $this->jwt
            ->sign($this->signingKey,"RS256")
            ->encrypt($this->encryptionKey)
            ->toString();
    }
}