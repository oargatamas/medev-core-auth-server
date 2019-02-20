<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:03
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;


use Lcobucci\JWT\Parser;
use MedevAuth\Services\Auth\OAuth\Actions\Client\GetClientData;
use MedevAuth\Services\Auth\OAuth\Actions\User\GetUserData;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Utils\CryptUtils;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

/**
 * Class ParseToken
 * @package MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS
 */
abstract class ParseToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return OAuthJWS
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $jwt = (new Parser())->parse($args["token"]);

        $client = (new GetClientData($this->service))->handleRequest(["client_id" => $jwt->getClaim("cli")]);
        $user = (new GetUserData($this->service))->handleRequest(["user_id" => $jwt->getClaim("usr")]);;
        $privateKey = CryptUtils::getKeyFromConfig($this->config["auth"]["token"]["private_key"]);

        $token = new OAuthJWS();
        $token->setJwt($jwt);

        $token->setIdentifier($jwt->getHeader("jti"));
        $token->setExpiration($jwt->getClaim("exp"));
        $token->setScopes($jwt->getClaim("scopes"));
        $token->setClient($client);
        $token->setUser($user);
        $token->setPrivateKey($privateKey);

        return $this->withServerState($token);
    }

    /**
     * @param OAuthJWS $token
     * @return OAuthJWS
     */
    protected abstract function withServerState(OAuthJWS $token);
}