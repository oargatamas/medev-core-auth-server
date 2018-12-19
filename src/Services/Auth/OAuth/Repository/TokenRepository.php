<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;








use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token;
use MedevAuth\Services\Auth\OAuth\Entity\User;

class TokenRepository extends DBRepository
{

    /**
     * @param Client $client
     * @param User $user
     * @param array $scopes
     */
    public function generateToken(Client $client, User $user, array $scopes){

    }


    /**
     * @param User $user
     */
    public function getTokenForUser(User $user){

    }


    /**
     * @param Token $token
     */
    public function persistToken(Token $token){

    }


    /**
     * @param $tokenIdentifier
     */
    public function revokeToken($tokenIdentifier){

    }


    /**
     * @param $tokenString
     */
    public function validateSerializedToken($tokenString){

    }


    /**
     * @param Token $token
     */
    public function isTokenBlackListed(Token $token){

    }


    /**
     * @param $tokenString
     */
    public function parseToken($tokenString){

    }

}