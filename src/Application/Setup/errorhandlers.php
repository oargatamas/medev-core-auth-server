<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 07.
 * Time: 13:25
 */

use MedevSlim\Core\ErrorHandlers\APIExceptionHandler;
use MedevSlim\Core\ErrorHandlers\NotAllowedHandler;
use MedevSlim\Core\ErrorHandlers\NotFoundHandler;
use MedevSlim\Core\ErrorHandlers\PHPRuntimeHandler;



$container["errorHandler"] = function () use ($container) {
    return new APIExceptionHandler($container->get('settings')['displayErrorDetails']);
};

$container["phpErrorHandler"] = function () {
    return new PHPRuntimeHandler();
};
$container["notFoundHandler"] = function () {
    return new NotFoundHandler();
};
$container["notAllowedHandler"] = function () {
    return new NotAllowedHandler();
};