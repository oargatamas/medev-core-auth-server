<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:08
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\ClientEntityInterface;
use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;

interface ClientRepositoryInterface
{
    /**
     * @param string $clientIdentifier
     * @return ClientEntityInterface
     * @throws UnauthorizedException
     */
    public function getClientEntity($clientIdentifier);

    /**
     * @param ClientEntityInterface $clientIdentifier
     * @param string $secret
     * @param boolean $validateSecret
     * @return boolean
     * @throws UnauthorizedException
     */
    public function validateClient(ClientEntityInterface $clientIdentifier, $secret, $validateSecret);
}