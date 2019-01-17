<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;








use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;

interface TokenRepository
{

    /**
     * @param Client $client
     * @param User $user
     * @param string[] $scopes
     * @return OAuthToken
     */
    public function generateToken(Client $client, User $user, $scopes);


    /**
     * @param string $tokenIdentifier
     * @throws RepositoryException
     */
    //public function getToken($tokenIdentifier);


    /**
     * @param OAuthToken $token
     * @throws RepositoryException
     */
    public function persistToken(OAuthToken $token);

    /**
     * @param string $tokenIdentifier
     * @throws RepositoryException
     */
    public function revokeToken($tokenIdentifier);


    /**
     * @param string $tokenString
     * @throws UnauthorizedException
     * @return OAuthToken
     */
    public function validateSerializedToken($tokenString);


    /**
     * @param OAuthToken $token
     * @return bool
     */
    public function isTokenBlackListed(OAuthToken $token);


    /**
     * @param $tokenString
     * @return OAuthToken
     * @throws RepositoryException
     */
    public function parseToken($tokenString);

}