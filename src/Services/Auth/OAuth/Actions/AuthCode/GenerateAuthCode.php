<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:20
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Utils\RandomString;

class GenerateAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return AuthCode
     * @throws \Exception
     */
    public function handleRequest($args)
    {
        /** @var Client $args */
        $client = $args["client"]; //Todo move to constant
        $now = new DateTime();

        $authCode = new AuthCode();

        $authCode->setClient($client);
        $authCode->setIdentifier(RandomString::generate(20));
        $authCode->setCreatedAt($now->getTimestamp());
        $authCode->setExpiresAt($now->modify("+5 minutes")->getTimestamp());
        $authCode->setRedirectUri($client->getRedirectUri());

        return $authCode;
    }
}