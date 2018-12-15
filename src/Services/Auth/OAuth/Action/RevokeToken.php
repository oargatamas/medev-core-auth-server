<?php


namespace MedevAuth\Services\Auth\OAuth\Action;


use MedevAuth\Services\Auth\OAuth\Repository\TokenRepositoryInterface;
use MedevSlim\Core\APIAction\APIAction;
use Slim\Http\Request;
use Slim\Http\Response;

class RevokeToken extends APIAction
{

    protected function onPermissionGranted(Request $request, Response $response, $args)
    {
        /* @var TokenRepositoryInterface $refreshTokenRepository */
        $refreshTokenRepository = $this->container->get("OauthRefreshTokenRepository");

        $refreshTokenRepository->revokeToken($args["tokenId"]);
    }
}