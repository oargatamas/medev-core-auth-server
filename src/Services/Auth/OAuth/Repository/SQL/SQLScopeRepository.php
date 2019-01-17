<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:46
 */

namespace MedevAuth\Services\Auth\OAuth\Repository\SQL;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\Repository\ScopeRepository;
use MedevSlim\Core\Database\SQL\SQLRepository;
use Medoo\Medoo;


/**
 * Class SQLScopeRepository
 * @package MedevAuth\Services\Auth\OAuth\Repository\SQL
 * {@inheritdoc}
 */
class SQLScopeRepository extends SQLRepository implements ScopeRepository
{

    public function __construct(Medoo $db)
    {
        parent::__construct($db);
    }


    public function getUserScopes(User $user)
    {
        $result = $this->db->select("OAuth_UserScopes",
            ["ScopeId"],
            ["UserId" => $user->getIdentifier()]
        );

        $userScopes = array_reduce($result, 'array_merge', array());;

        return $userScopes;
    }


    public function getClientScopes(Client $client)
    {
        $result = $this->db->select("OAuth_ClientScopes",
            ["ScopeId"],
            ["ClientId" => $client->getIdentifier()]
        );

        $clientScopes = array_reduce($result, 'array_merge', array());;

        return $clientScopes;
    }


    public function getRefreshTokenScopes()
    {
        return ["get:accesstoken"];
    }
}