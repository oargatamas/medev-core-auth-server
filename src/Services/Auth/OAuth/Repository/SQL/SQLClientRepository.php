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
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Database\SQL\SQLRepository;
use Medoo\Medoo;

/**
 * Class SQLClientRepository
 * @package MedevAuth\Services\Auth\OAuth\Repository\SQL
 * {@inheritdoc}
 */
class SQLClientRepository extends SQLRepository implements ClientRepository
{

    public function __construct(Medoo $db)
    {
        parent::__construct($db);
    }



    public function getClientEntity($clientIdentifier)
    {
        $storedData = $this->db->get("OAuth_Clients",
            [
                "Id","Name","Secret","RedirectURI","Status"
            ],
            [
                "Id" => $clientIdentifier
            ]
        );

        //Todo test it briefly
        if(empty($storedData) || is_null($storedData)){
            throw new RepositoryException("Client ".$clientIdentifier." not existing in the database.");
        }

        $clientEntity = new Client();
        $clientEntity->setIdentifier($storedData["Id"]);
        $clientEntity->setName($storedData["Name"]);
        $clientEntity->setRedirectUri($storedData["RedirectURI"]);
        $clientEntity->setSecret($storedData["Secret"]);

        return $clientEntity;
    }


    public function validateClient(Client $client, $validateSecret)
    {
        $storedData = $this->db->get("OAuth_Clients",
            [ "Id", "Secret"],
            [
            "Id" => $client->getIdentifier()
            ]
        );

        if(!$storedData || empty($storedData) || is_null($storedData)){
            throw  new RepositoryException("Client not registered");
        }

        if($validateSecret && !password_verify($client->getSecret(),$storedData["Secret"])){
            throw new RepositoryException("Provided secret is invalid for Client.");
        }
    }
}