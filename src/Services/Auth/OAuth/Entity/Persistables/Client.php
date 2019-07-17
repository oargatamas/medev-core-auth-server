<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 13:20
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;


use MedevAuth\Services\Auth\OAuth\Entity;
use Medoo\Medoo;

class Client implements MedooPersistable
{

    /**
     * @param $storedData
     * @return Entity\Client
     */
    public static function fromAssocArray($storedData)
    {
        $client = new Entity\Client();

        $client->setIdentifier($storedData["ClientId"]);
        $client->setName($storedData["ClientName"]);
        $client->setSecret($storedData["ClientSecret"]);
        $client->setRedirectUri($storedData["ClientRedirect"]);
        $client->setTokenPlace($storedData["ClientTokenPlace"]);
        $client->setScopes(explode(",", $storedData["ClientScopes"]));
        $client->setGrantTypes(explode(",", $storedData["ClientGrantTypes"]));

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
        return [
            "ClientId" => Medoo::raw("<c.Id>"),
            "ClientName" => Medoo::raw("<c.Name>"),
            "ClientSecret" => Medoo::raw("<c.Secret>"),
            "ClientRedirect" => Medoo::raw("<c.RedirectURI>"),
            "ClientTokenPlace" => Medoo::raw("<c.SendTokenIn>"),
            "ClientStatus" => Medoo::raw("<c.Status>"),
            "ClientCreated" => Medoo::raw("<c.CreatedAt>"),
            "ClientUpdated" => Medoo::raw("<c.UpdatedAt>")
        ];
    }
}