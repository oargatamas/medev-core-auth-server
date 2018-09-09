<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 07.
 * Time: 13:26
 */

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$container["logger"] = function(){
      $logger = new Logger('MedevSuiteAuthServer');

      $logger->pushHandler(new StreamHandler(__DIR__."/../../../log/app.log",Logger::DEBUG));

      return $logger;
};