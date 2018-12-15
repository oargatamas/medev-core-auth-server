<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:57
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


interface EntityInterface
{
    public function getIdentifier();

    public function setIdentifier($identifier);
}