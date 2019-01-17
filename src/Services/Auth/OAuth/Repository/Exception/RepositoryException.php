<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 01. 11.
 * Time: 16:24
 */

namespace MedevAuth\Services\Auth\OAuth\Repository\Exception;


class RepositoryException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message, 0, null);
    }


    public function __toString()
    {
        return get_class($this) . " - " .$this->getMessage();
    }
}