<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 06.
 * Time: 14:19
 */

namespace MedevAuthExample\Sample\Actions;


use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class GetResource extends APIServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        $data = [
            "status" => "success",
            "message" => "megy ez!",
            "user" => $request->getAttribute("user_id"),
            "client" => $request->getAttribute("client_id"),
            "scopes" => $request->getAttribute("scopes")
        ];

        return $response->withJson($data,200);
    }
}