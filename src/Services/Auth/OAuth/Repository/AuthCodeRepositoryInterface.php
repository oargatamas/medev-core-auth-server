<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:06
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCodeEntity;

interface AuthCodeRepositoryInterface
{
    public function getNewAuthCode();

    public function persistNewAuthCode(AuthCodeEntity $authCode);

    public function revokeAuthCode($codeIdentifier);

    public function isAuthCodeRevoked($codeIdentifier);

    public function validateAuthCode(AuthCodeEntity $authCode);
}