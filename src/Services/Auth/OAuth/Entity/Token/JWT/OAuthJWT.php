<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 17:04
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token\JWT;


use JOSE_JWT;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;

class OAuthJWT extends OAuthToken
{

    /**
     * @var JOSE_JWT
     */
    protected $jwt;


    /**
     * OAuthJWT constructor.
     * @param JOSE_JWT $jwt
     */
    public function __construct(JOSE_JWT $jwt)
    {
        $this->jwt = $jwt;
        parent::__construct();
    }



    public function setIdentifier($identifier)
    {
        $this->jwt->claims["jti"] = $identifier;
        parent::setIdentifier($identifier);
    }

    public function setScopes($scopes)
    {
        $this->jwt->claims["scopes"] = array_values($scopes);
        parent::setScopes($scopes);
    }

    public function addScope($scope)
    {
        $this->jwt->claims["scopes"][] = $scope;
        parent::addScope($scope);
    }


    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->jwt->claims["iat"] = $createdAt->getTimestamp();
        parent::setCreatedAt($createdAt);
    }

    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->jwt->claims["exp"] = $expiresAt->getTimestamp();
        parent::setExpiresAt($expiresAt);
    }

    public function setClient(Client $client)
    {
        $clientData = [
            "id" => $client->getIdentifier(),
            "name" => $client->getName(),
            "redirectUri" => $client->getRedirectUri(),
        ];
        $this->jwt->claims["client"] = $clientData;

        parent::setClient($client);
    }

    public function setUser(User $user)
    {
        $userData = [
            "id" => $user->getIdentifier(),
            "email" => $user->getEmail()
        ];
        $this->jwt->claims["user"] = $userData;
        parent::setUser($user);
    }

    public function addCustomData($key, $data)
    {
        $this->jwt->claims[$key] = $data;
        parent::addCustomData($key, $data);
    }

    public function removeCustomData($key)
    {
        $this->jwt->claims[$key] = null;
        parent::removeCustomData($key);
    }


    /**
     * @return string
     */
    public function finalizeToken()
    {
        return $this->jwt->toString();
    }


}