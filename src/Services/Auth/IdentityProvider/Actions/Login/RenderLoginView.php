<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:02
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

class RenderLoginView extends APITwigServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Twig_Error_Loader
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        /** @var Twig $view */
        $view = $this->service->getContainer()->get("view");
        /** @var FilesystemLoader $viewLoader */
        $viewLoader = $this->service->getContainer()->get("view_loader");
        $viewLoader->addPath(__DIR__."/View", $this->service->getServiceName());


        $this->info("Megvan a view");

        return $this->render($response,"LoginScreen.twig",[]);
    }
}