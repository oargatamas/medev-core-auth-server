<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 17:04
 */

namespace MedevAuth\Token\JWT;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use MedevAuth\Services\Auth\OAuth\Entity\ClientEntityInterface;
use MedevAuth\Services\Auth\OAuth\Entity\TokenEntityInterface;
use MedevAuth\Services\Auth\OAuth\Entity\UserEntityInterface;

class JWT implements TokenEntityInterface
{

    /**
     * @var Token
     */
    protected $jwt;
    /**
     * @var string
     */
    protected $identifier;
    /**
     * @var int
     */
    protected $expiration;
    /**
     * @var array
     */
    protected $scopes;
    /**
     * @var ClientEntityInterface
     */
    protected $client;
    /**
     * @var UserEntityInterface
     */
    protected $user;



    /**
     * @param string $serializedToken
     * @return JWT
     */
    public static function fromString($serializedToken){
        $jwt = (new Parser())->parse($serializedToken);

        $token = new JWT();
        $token->setJwt($jwt);

        $token->setIdentifier($jwt->getHeader("jti"));
        $token->setExpiration($jwt->getClaim("exp"));
        $token->setScopes($jwt->getClaim("scopes"));
        //Todo find out how can we add Client, User and Privatekey content from here

        return $token;
    }

    /**
     * @param Token $jwt
     */
    public function setJwt(Token $jwt)
    {
        $this->jwt = $jwt;
    }



    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param int $expiration
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }


    /**
     * @param string $scope
     */
    public function addScope($scope)
    {
        $this->scopes[] = $scope;
    }

    /**
     * @return ClientEntityInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return UserEntityInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserEntityInterface $user
     */
    public function setUser(UserEntityInterface $user)
    {
        $this->user = $user;
    }


    /**
     * @return string
     */
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
            ->getToken();

        return $token->__toString();
    }


}