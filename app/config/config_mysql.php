<?php

return [
    // Set up details on how to connect to the database
    'dsn'     => "mysql:host=localhost;dbname=alltomekonomi;",
    'username'        => "emwc15",
    'password'        => 'L1?"#6iK',
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "aoe_",

    // Display details on what happens
    //'verbose' => true,

    // Throw a more verbose exception when failing to connect
    //'debug_connect' => 'true',
];
