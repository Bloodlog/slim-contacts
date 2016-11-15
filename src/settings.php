<?php
return [
    'settings' => [
        'title' => 'Склад онлайн',
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'debug'  => true,
        // Renderer settings
        /*'renderer' => [
            'template_path' => __DIR__ . 'templates/',
            'cache' => __DIR__ . 'assets/'
        ],*/
        // DB settings
        /*'db' => [
            'host' => 'localhost',
            'dbname' => 'slim-contacts',
            'user' => 'root',
            'pass' => '',
        ],*/
        // View settings
        'view' => [
            'template_path' => __DIR__ . '/../templates',
            'twig' => [
                'cache' => __DIR__ . '/../public/assets',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],


        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
