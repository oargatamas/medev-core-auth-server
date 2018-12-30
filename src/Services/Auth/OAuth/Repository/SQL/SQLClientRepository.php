<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 17:46
 */

namespace MedevAuth\Services\Auth\OAuth\Repository\SQL;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Repository\ClientRepository;
use MedevSlim\Core\Database\SQL\SQLRepository;
use Medoo\Medoo;

class SQLClientRepository extends SQLRepository implements ClientRepository
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
     * @param string $clientIdentifier
     * @return Client
     */
    public function getClientEntity($clientIdentifier)
    {
        // TODO: Implement getClientEntity() method.
    }

    /**
     * @param Client $clientIdentifier
     * @param string $secret
     * @param bool $validateSecret
     */
    public function validateClient(Client $clientIdentifier, $secret, $validateSecret)
    {
        // TODO: Implement validateClient() method.
    }
}