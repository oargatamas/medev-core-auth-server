<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:51
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token;

use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ValidateToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return OAuthJWS
     * @throws UnauthorizedException
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        /** @var OAuthJWS $token */
        $token = $args["token"]; //Todo move to constant

        if (!$token->verifySignature()) {
            throw new UnauthorizedException("Invalid token signature.");
        }

        if ($token->isExpired()) {
            throw new UnauthorizedException("Token expired.");
        }

        if ($token->isRevoked()) {
            throw new UnauthorizedException("Token blacklisted.");
        }

        return $token;
    }
}