<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:51
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;

use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ValidateToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return OAuthJWS
     * @throws UnauthorizedException
     */
    public function handleRequest($args)
    {
        try{
            /** @var OAuthJWS $token */
            $token = $this->parseToken($args);
        }catch (\Exception $e){
            throw new UnauthorizedException($e->getMessage());
        }

        $token->setPrivateKey($this->config->privateKey);

        if (!$token->verifySignature($this->config->publicKey)) {
            throw new UnauthorizedException("Invalid token signature.");
        }

        if ($this->isTokenBlacklisted($token)) {
            throw new UnauthorizedException("Token blacklisted.");
        }

        return $token;
    }
}