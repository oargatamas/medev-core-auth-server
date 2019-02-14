<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 16.
 * Time: 10:15
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\OAuthJWT;

class OAuthJWS extends OAuthJWT
{
    /**
     * @var Key
     */
    private $privateKey; //Todo Create key object which can provide the private key and passphrase


    public function __construct(Key $privateKey = null)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @param Key $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public function verifySignature(Key $publicKey){
        return $this->jwt->verify(new Sha256(),$publicKey->getContent());
    }

    public function finalizeToken()
    {
        $token = (new Builder())
            ->setId($this->identifier, true)
            ->setSubject($this->user->getIdentifier())
            ->setAudience($this->client->getIdentifier())
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration($this->expiration)
            ->set("scopes", $this->scopes)
            ->sign( new Sha256(), $this->privateKey)
            ->getToken();

        return $token->__toString();
    }


}