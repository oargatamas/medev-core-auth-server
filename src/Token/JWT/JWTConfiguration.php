<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 04.
 * Time: 16:13
 */

namespace MedevAuth\Token\JWT;


interface JWTConfiguration
{
    public function getISS();
    public function getSUB();
    public function getAUD();
    public function getEXP();
    public function getNBF();
    public function getIAT();
    public function getJTI();
}