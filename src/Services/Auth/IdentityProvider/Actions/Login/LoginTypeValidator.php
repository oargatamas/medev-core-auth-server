<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 11. 23.
 * Time: 16:07
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Logging\ComponentLogger;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\APIException;
use MedevSlim\Core\Service\Exceptions\ForbiddenException;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;

class LoginTypeValidator implements ComponentLogger
{
    /**
     * @var APIService
     */
    private $service;

    /**
     * @var RouterInterface
     */
    protected $router;


    /**
     * @var string
     */
    private $requiredLoginType;

    /**
     * OAuthAPIProtector constructor.
     * @param APIService $service
     * @param string $requiredLoginType
     */
    public function __construct(APIService $service, $requiredLoginType)
    {
        $this->service = $service;
        $this->router = $service->getContainer()->get(MedevApp::ROUTER);
        $this->requiredLoginType = $requiredLoginType;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        try{
            $sessionData = $_SESSION["AuthParams"] ?? null; //Todo replace it with Id token validator

            if(!$sessionData){
                throw new UnauthorizedException("Session expired or not set correctly.", true);
            }

            $clientLoginTypes = $sessionData["client_auth_types"];

            if(!in_array($this->requiredLoginType, $clientLoginTypes)){
                throw new ForbiddenException("Client not allowed to login with ".$this->requiredLoginType. ". Try other login method.",true);
            }
        }
        catch(APIException $e){
            $this->error($e->__toString());
            $errorParams = [
                "error" => $e->getMessage(),
                "opened_at" => 1
            ];
            $loginUrl = $this->router->pathFor(LoginTypes::REDIRECT[$this->requiredLoginType],[],$errorParams);
            return $response->withRedirect($loginUrl);
        }

        return $next($request, $response);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function debug($message, $args = [])
    {
        $this->service->debug($message, $args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function info($message, $args = [])
    {
        $this->service->info($message, $args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function warn($message, $args = [])
    {
        $this->service->warn($message, $args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function error($message, $args = [])
    {
        $this->service->error($message, $args);
    }
}