<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:47
 */

namespace MedevAuth\Services\Auth\OAuth\Repository\SQL;


use MedevAuth\Services\Auth\OAuth\Repository\UserRepository;
use MedevSlim\Core\Database\SQL\SQLRepository;
use Medoo\Medoo;

class SQLUserRepository extends SQLRepository implements UserRepository
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
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function validateUser($username, $password)
    {
        // TODO: Implement validateUser() method.
    }
}