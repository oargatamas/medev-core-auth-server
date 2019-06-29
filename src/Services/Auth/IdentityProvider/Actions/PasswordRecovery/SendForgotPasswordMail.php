<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 13:51
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\BadRequestException;
use MedevSlim\Core\View\TwigView;
use PHPMailer\PHPMailer\PHPMailer;
use Slim\Views\Twig;

class SendForgotPasswordMail extends APIRepositoryAction
{

    /**
     * @var Twig
     */
    private $view;

    public function __construct(APIService $service)
    {
        $this->view = $service->getContainer()->get(TwigView::class);
        parent::__construct($service);
    }

    /**
     * @param $args
     * @throws BadRequestException
     */
    public function handleRequest($args = [])
    {
        /** @var AuthCode $authCode */
        $authCode = $args[AuthCode::IDENTIFIER];
        $user = $authCode->getUser();

        $mail = new PHPMailer(true);

        try {
            $mail->setFrom("noreply@medev.hu", "Noreply-MedevServices");
            $mail->addAddress($user->getEmail(), $user->getUsername());
            $mail->addBCC("tudomtom@gmail.com", "Oarga Tamás");

            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->Subject = "MedevServices - Elfelejtett jelszó";

            $mailData = [
                "username" => $user->getUsername(),
                "token" => $authCode->finalizeAuthCode()
            ];

            $mail->Body = $this->view->fetch("@".$this->service->getServiceName()."/"."ForgotPasswordMailTemplate.twig",$mailData);

            $mail->send();

        } catch (\Exception $e) {
            throw new BadRequestException("Mail to customer can not be sent. ". $mail->ErrorInfo);
        }
    }
}