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

class SQLScopeRepository extends SQLRepository implements ScopeRepository
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
     * @param User $user
     * @return string[]
     */
    public function getUserScopes(User $user)
    {
        // TODO: Implement getUserScopes() method.
    }

    /**
     * @param Client $client
     * @return string[]
     */
    public function getClientScopes(Client $client)
    {
        // TODO: Implement getClientScopes() method.
    }

    /**
     * @return string[]
     */
    public function getRefreshTokenScopes()
    {
        // TODO: Implement getRefreshTokenScopes() method.
    }
}