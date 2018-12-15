<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;







use MedevAuth\Services\Auth\OAuth\Entity\ClientEntityInterface;
use MedevAuth\Services\Auth\OAuth\Entity\TokenEntityInterface;
use MedevAuth\Services\Auth\OAuth\Entity\UserEntityInterface;

interface TokenRepositoryInterface
{
    /**
     * @param ClientEntityInterface $client
     * @param UserEntityInterface $user
     * @param array $scopes
     * @return TokenEntityInterface
     */
    public function generateToken(ClientEntityInterface $client, UserEntityInterface $user, array $scopes);

    /**
     * @param UserEntityInterface $user
     * @return TokenEntityInterface
     */
    public function getTokenForUser(UserEntityInterface $user);

    /**
     * @param TokenEntityInterface $token
     * @return void
     */
    public function persistToken(TokenEntityInterface $token);

    /**
     * @param int $tokenIdentifier
     * @return void
     */
    public function revokeToken($tokenIdentifier);

    /**
     * @param $tokenString
     * @return TokenEntityInterface
     */
    public function validateSerializedToken($tokenString);

    /**
     * @param TokenEntityInterface $token
     * @return boolean
     */
    public function isTokenBlackListed(TokenEntityInterface $token);

    /**
     * @param $tokenString
     * @return TokenEntityInterface
     */
    public function parseToken($tokenString);

}