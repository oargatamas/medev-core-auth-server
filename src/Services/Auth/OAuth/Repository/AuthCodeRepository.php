<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:06
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;

class AuthCodeRepository extends DBRepository
{
    /**
     * @return AuthCode
     */
    public function getNewAuthCode(){

    }

    /**
     * @param AuthCode $authCode
     */
    public function persistNewAuthCode(AuthCode $authCode){

    }

    /**
     * @param $codeIdentifier
     * @return bool
     */
    public function revokeAuthCode($codeIdentifier){

    }

    /**
     * @param $codeIdentifier
     * @return bool
     */
    public function isAuthCodeRevoked($codeIdentifier){

    }

    /**
     * @param AuthCode $authCode
     * @return bool
     */
    public function validateAuthCode(AuthCode $authCode){

    }
}