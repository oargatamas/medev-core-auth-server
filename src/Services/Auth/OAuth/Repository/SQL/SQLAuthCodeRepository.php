<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:28
 */

namespace MedevAuth\Services\Auth\OAuth\Repository\SQL;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Repository\AuthCodeRepository;
use MedevSlim\Core\Database\SQL\SQLRepository;
use Medoo\Medoo;

class SQLAuthCodeRepository extends SQLRepository implements AuthCodeRepository
{
    /**
     * SQLAuthCodeRepository constructor.
     * @param Medoo $db
     */
    public function __construct(Medoo $db)
    {
        parent::__construct($db);
    }

    /**
     * @return AuthCode
     */
    public function getNewAuthCode()
    {
        // TODO: Implement getNewAuthCode() method.
    }

    /**
     * @param AuthCode $authCode
     */
    public function persistNewAuthCode(AuthCode $authCode)
    {
        // TODO: Implement persistNewAuthCode() method.
    }

    /**
     * @param $codeIdentifier
     * @return bool
     */
    public function revokeAuthCode($codeIdentifier)
    {
        // TODO: Implement revokeAuthCode() method.
    }

    /**
     * @param $codeIdentifier
     * @return bool
     */
    public function isAuthCodeRevoked($codeIdentifier)
    {
        // TODO: Implement isAuthCodeRevoked() method.
    }

    /**
     * @param AuthCode $authCode
     * @return bool
     */
    public function validateAuthCode(AuthCode $authCode)
    {
        // TODO: Implement validateAuthCode() method.
    }
}