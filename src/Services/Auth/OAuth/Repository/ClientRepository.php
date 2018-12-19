<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:08
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\Client;

interface ClientRepository
{

    /**
     * @param string $clientIdentifier
     * @return Client
     */
    public function getClientEntity($clientIdentifier);

    /**
     * @param Client $clientIdentifier
     * @param string $secret
     * @param bool $validateSecret
     */
    public function validateClient(Client $clientIdentifier, $secret, $validateSecret);
}