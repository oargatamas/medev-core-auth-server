<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;








use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\GenericToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;

interface TokenRepository
{

    /**
     * @param Client $client
     * @param User $user
     * @param string[] $scopes
     */
    public function generateToken(Client $client, User $user, $scopes);


    /**
     * @param string $tokenIdentifier
     */
    public function getToken($tokenIdentifier);


    /**
     * @param GenericToken $token
     */
    public function persistToken(GenericToken $token);

    /**
     * @param string $tokenIdentifier
     */
    public function revokeToken($tokenIdentifier);


    /**
     * @param string $tokenString
     */
    public function validateSerializedToken($tokenString);


    /**
     * @param GenericToken $token
     * @return bool
     */
    public function isTokenBlackListed(GenericToken $token);


    /**
     * @param $tokenString
     * @return GenericToken
     */
    public function parseToken($tokenString);

}