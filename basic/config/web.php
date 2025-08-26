<?php

use app\repositories\ContactRepository;
use app\repositories\DealRepository;
use app\services\ContactService;
use app\services\DealService;
use yii\di\Container;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'deals' => 'deal/index',
                'deals/create' => 'deal/create',
                'deals/view/<id:\d+>' => 'deal/view',
                'deals/update/<id:\d+>' => 'deal/update',
                'deals/delete/<id:\d+>' => 'deal/delete',

                'contacts' => 'contact/index',
                'contacts/create' => 'contact/create',
                'contacts/view/<id:\d+>' => 'contact/view',
                'contacts/update/<id:\d+>' => 'contact/update',
                'contacts/delete/<id:\d+>' => 'contact/delete',
            ]
        ],
        'container' => [
            'class' => Container::class,
            'definitions' => [
                DealService::class => function () {
                    return new DealService(Yii::$container->get(DealRepository::class));
                },
                ContactService::class => function () {
                    return new ContactService(Yii::$container->get(ContactRepository::class));
                }
            ],
            'singletons' => [
                DealRepository::class => DealRepository::class,
                ContactRepository::class => ContactRepository::class
            ]
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'NbjUArrhpAO0_8vtUQAoVFAdtRCotKSD',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

return $config;
