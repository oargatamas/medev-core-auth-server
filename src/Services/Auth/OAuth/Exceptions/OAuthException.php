<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 14.
 * Time: 9:57
 */

namespace MedevAuth\Services\Auth\OAuth\Exceptions;


use MedevSlim\Core\Service\Exceptions\APIException;

/**
 * Class OAuthException
 * @package MedevAuth\Services\Auth\OAuth\Exceptions
 */
class OAuthException extends APIException
{
    /**
     * OAuthException constructor.
     * @param string $reason
     */
    public function __construct($reason = "")
    {
        parent::__construct("Internal Server Error", 500, $reason);
    }

}