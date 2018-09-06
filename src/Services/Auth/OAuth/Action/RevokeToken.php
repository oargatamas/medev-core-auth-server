<?php

use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;

/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 11:24
 */

namespace MedevAuth\Services\Auth\OAuth\Action;


use MedevSlim\Core\APIAction\APIAction;
use Slim\Http\Request;
use Slim\Http\Response;

class RevokeToken extends APIAction
{

    protected function onPermissionGranted(Request $request, Response $response, $args)
    {
        /* @var TokenRepository $refreshTokenRepository */
        $refreshTokenRepository = $this->container->get("OauthRefreshTokenRepository");

        $refreshTokenRepository->revokeToken($args["tokenId"]);
    }
}