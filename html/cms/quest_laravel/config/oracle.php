<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', ''),
        'host'           => env('DB_HOST', '10.40.83.63'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', '(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.40.83.63)(PORT = 1521)) )(CONNECT_DATA =(SID= SSCMISC_2)))'),
        'username'       => env('DB_USERNAME', 'HMSVIEW'),
        'password'       => env('DB_PASSWORD', 'Hmsview123#'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
