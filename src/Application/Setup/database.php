<?php

use Medoo\Medoo;

$container["database"] = function ($container) {
    $db = new Medoo(
        ['database_type' => 'mysql',
            'database_name' => 'medevsuite_auth',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',]
    );

    return $db;
};