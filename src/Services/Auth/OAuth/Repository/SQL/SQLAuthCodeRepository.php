<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:28
 */

namespace MedevAuth\Services\Auth\OAuth\Repository\SQL;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Repository\AuthCodeRepository;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Database\SQL\SQLRepository;
use MedevSlim\Utils\RandomString;
use Medoo\Medoo;



/**
 * Class SQLAuthCodeRepository
 * @package MedevAuth\Services\Auth\OAuth\Repository\SQL
 * {@inheritdoc}
 */
class SQLAuthCodeRepository extends SQLRepository implements AuthCodeRepository
{

    public function __construct(Medoo $db)
    {
        parent::__construct($db);
    }


    public function getNewAuthCode(Client $client)
    {
        $now = new DateTime();

        $authCode = new AuthCode();

        $authCode->setClient($client);
        $authCode->setIdentifier(RandomString::generate(20));
        $authCode->setCreatedAt($now->getTimestamp());
        $authCode->setExpiresAt($now->modify("+5 minutes")->getTimestamp());
        $authCode->setRedirectUri($client->getRedirectUri());

        return $authCode;
    }

    public function persistNewAuthCode(AuthCode $authCode)
    {
        $this->db->insert("OAuth_AuthCodes",[
            "Id" => $authCode->getIdentifier(),
            "ClientId" => $authCode->getClient()->getIdentifier(),
            "RedirectURI" => $authCode->getRedirectUri(),
            "CreatedAt" => $authCode->getCreatedAt(),
            "Expiration" => $authCode->getExpiresAt(),
        ]);

        //Todo test is briefly
        $result = $this->db->error();
        if(!is_null($result)){
            throw new RepositoryException(implode(" - ",$result));
        }
    }


    public function revokeAuthCode($codeIdentifier)
    {
        $this->db->update("OAuth_AuthCodes",
            [
                "IsRevoked" => true
            ],
            [
                "Id" => $codeIdentifier
            ]);

        //Todo test is briefly
        $result = $this->db->error();
        if(!is_null($result)){
            throw new RepositoryException(implode(" - ",$result));
        }
    }


    public function isAuthCodeRevoked($codeIdentifier)
    {
        $result = $this->db->has("OAuth_AuthCodes",
            [
                "Id" => $codeIdentifier,
                "IsRevoked" => true
            ]);

        return $result;
    }

    public function validateAuthCode(AuthCode $authCode)
    {
        $result = $this->db->has("OAuth_AuthCodes",
            [
                "Id" => $authCode->getIdentifier(),
                "IsRevoked" => false,
                "ExpiresAt[>]" => date('Y\-m\-d\ h:i:s')
            ]);

        if(!$result){
            throw new RepositoryException("Authcode ".$authCode->getIdentifier()." not valid.");
        }
    }
}