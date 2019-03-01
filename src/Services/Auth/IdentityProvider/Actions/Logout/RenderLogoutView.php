<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 01.
 * Time: 17:29
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Logout;



use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class RenderLogoutView extends APITwigServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        return $response;
    }


}