<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:47
 */

namespace MedevAuth\Services\Auth\OAuth\Repository\SQL;


use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevAuth\Services\Auth\OAuth\Repository\UserRepository;
use MedevSlim\Core\Database\SQL\SQLRepository;
use Medoo\Medoo;


/**
 * Class SQLUserRepository
 * @package MedevAuth\Services\Auth\OAuth\Repository\SQL
 * {@inheritdoc}
 */
class SQLUserRepository extends SQLRepository implements UserRepository
{

    public function __construct(Medoo $db)
    {
        parent::__construct($db);
    }


    public function validateUser($username, $password)
    {
        $storedData = $this->db->get("OAuth_Users",
            ["UserName", "Email", "Password"],
            [
                "AND" => [
                    "OR" =>[
                        "UserName" => $username,
                        "Email" => $username
                    ],
                    "Verified" => 1,
                    "Disabled" => 0
                ]
            ]
        );

        if(!$storedData || empty($storedData) || is_null($storedData)){
            throw new RepositoryException("User ".$username." not registered or disabled.");
        }

        if(!password_verify($password,$storedData["Password"])){
            throw new RepositoryException("Password for ".$username." is invalid");
        }
    }
}