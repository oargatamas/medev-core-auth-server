<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 20.
 * Time: 16:23
 */

namespace MedevAuth\Services\Auth\User\Actions\Repository\Registration;


use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\User\UserService;
use MedevSlim\Core\Action\Repository\Twig\APITwigRepositoryAction;
use MedevSlim\Core\Service\Exceptions\InternalServerException;
use PHPMailer\PHPMailer\PHPMailer;

class SendVerificationMail extends APITwigRepositoryAction
{
    const VERIFICATION_TOKEN = "verificationToken";
    const USER = "userInfo";

    /**
     * @param $args
     * @throws \Twig\Error\LoaderError
     * @throws InternalServerException
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function handleRequest($args = [])
    {
        /** @var User $user */
        $user = $args[self::USER];
        $code = $args[self::VERIFICATION_TOKEN];


        $authConfig= $this->config["authorization"];
        $params = ["code" => $code];
        $url = "https://".$authConfig["host"].$this->router->pathFor(UserService::ROUTE_VERIFY,[],$params);


        $mail = new PHPMailer(false);

        $mail->setFrom("noreply@medev.hu", "Noreply-MedevServices");
        $mail->addAddress($user->getEmail(), $user->getUsername());
        $mail->addBCC("tudomtom@gmail.com", "Oarga Tamás");

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = "MedevServices - User verification"; // Todo integrate with localization string

        $mailData = [
            "service" => $this->service->getServiceName(),
            "username" => $user->getUsername(),
            "usermail" => $user->getEmail(),
            "verificationToken" => $code,
            "verificationUrl" => $url
        ];

        $mail->Body = $this->render("RegistrationVerificationMail.twig",$mailData);

        if (!$mail->send()) {
            throw new InternalServerException("Mail notification to user can not be sent. ". $mail->ErrorInfo);
        }
    }
}