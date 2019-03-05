<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 13:20
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;


use MedevAuth\Services\Auth\OAuth\Entity;

class Client implements MedooPersistable
{

    /**
     * @param $storedData
     * @return Entity\Client
     */
    public static function fromAssocArray($storedData)
    {
        $client = new Entity\Client();

        $client->setIdentifier($storedData["Id"]);
        $client->setName($storedData["Name"]);
        $client->setSecret($storedData["Secret"]);
        $client->setRedirectUri($storedData["RedirectURI"]);
        $client->setScopes(explode(",",$storedData["ClientScopes"]));
        $client->setGrantTypes(explode(",",$storedData["ClientGrantTypes"]));

        return $client;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_Clients";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return ["c.Id","c.Name","c.Secret","c.RedirectURI","c.Status","c.CreatedAt","c.UpdatedAt"];
    }
}