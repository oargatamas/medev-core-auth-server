<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 13:51
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\APIException;
use MedevSlim\Core\View\TwigView;
use PHPMailer\PHPMailer\PHPMailer;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class SendForgotPasswordMail extends APIRepositoryAction
{

    /**
     * @var Twig
     */
    private $view;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(APIService $service)
    {
        $this->view = $service->getContainer()->get(TwigView::class);
        $this->router = $service->getContainer()->get(MedevApp::ROUTER);
        parent::__construct($service);
    }

    /**
     * @param $args
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws APIException
     */
    public function handleRequest($args = [])
    {
        /** @var AuthCode $authCode */
        $authCode = $args[AuthCode::IDENTIFIER];
        $user = $authCode->getUser();

        $mail = new PHPMailer(true);

        $mail->setFrom("noreply@medev.hu", "Noreply-MedevServices");
        $mail->addAddress($user->getEmail(), $user->getUsername());
        $mail->addBCC("tudomtom@gmail.com", "Oarga Tamás");

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = "MedevServices - Elfelejtett jelszó";

        $params = ["token" => $authCode->finalizeAuthCode()];
        $changePwUrl = "https://auth.medev.local".$this->router->pathFor(IdentityService::ROUTE_PASSWORD_RECOVERY,[],$params);

        $mailData = [
            "username" => $user->getUsername(),
            "changePasswordUrl" => $changePwUrl
        ];

        $mail->Body = $this->view->fetch("@" . $this->service->getServiceName() . "/ForgotPasswordMail.twig", $mailData);

        if (!$mail->send()) {
            throw new APIException($mail->ErrorInfo, 500, "Mail notification to user can not be sent.");
        }
    }
}