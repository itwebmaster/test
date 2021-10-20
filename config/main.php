<?php

$config = [
    'siteName'    => 'Test Task',
    'db'          => [
        'host' => '127.0.0.1',
        'dbname' => 'banner',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
    ],
    'bannersPath' => BASE_PATH . '/images/banners',
    'pages' => [
        '/index1.php' => 'Index 1 Page',
        '/index2.php' => 'Index 2 Page'
    ],
];

return $config;
