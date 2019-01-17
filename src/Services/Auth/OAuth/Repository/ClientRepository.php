<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:08
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;

interface ClientRepository
{

    /**
     * @param string $clientIdentifier
     * @throws RepositoryException
     * @return Client
     */
    public function getClientEntity($clientIdentifier);

    /**
     * @param Client $client
     * @param bool $validateSecret
     * @throws RepositoryException
     */
    public function validateClient(Client $client, $validateSecret);
}