<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 04.
 * Time: 11:03
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode;

use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\InternalServerException;
use MedevSlim\Core\View\TwigView;
use PHPMailer\PHPMailer\PHPMailer;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class SendLoginCodeInMail extends APIRepositoryAction
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
     * @param array $args
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws \Twig\Error\LoaderError
     * @throws InternalServerException
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
        $mail->Subject = "MedevServices - Authorization code"; //Todo integrate with localization string


        $mailData = [
            "username" => $user->getUsername(),
            "code" => $authCode->finalizeAuthCode()
        ];

        $mail->Body = $this->view->fetch("@" . $this->service->getServiceName() . "/LoginCodeMail.twig", $mailData);

        if (!$mail->send()) {
            throw new InternalServerException("Mail notification to user can not be sent. ". $mail->ErrorInfo);
        }
    }
}