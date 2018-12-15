<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:58
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


interface UserEntityInterface extends EntityInterface
{
    public function getUsername();

    public function setUsername();
}