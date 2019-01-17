<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:06
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;

interface AuthCodeRepository
{
    /**
     * @param Client $client
     * @return AuthCode
     */
    public function getNewAuthCode(Client $client);

    /**
     * @param AuthCode $authCode
     * @throws RepositoryException
     */
    public function persistNewAuthCode(AuthCode $authCode);

    /**
     * @param $codeIdentifier
     * @throws RepositoryException
     */
    public function revokeAuthCode($codeIdentifier);

    /**
     * @param $codeIdentifier
     * @return bool
     */
    public function isAuthCodeRevoked($codeIdentifier);

    /**
     * @param AuthCode $authCode
     * @throws RepositoryException
     */
    public function validateAuthCode(AuthCode $authCode);
}