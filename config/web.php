<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1');
$config = [
    'id' => 'GED',
    'name' => 'Gestin de Escuelas Deportivas',
    'language' => 'es',
    'timeZone' => 'America/Caracas',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'main',
    //'defaultRoute' =>'site/login',  // Default controller when no specific one is set in the URL
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mjbvsistemas-ged-voleibol-06012025',
            'baseUrl' => $isLocal ? '' : 'https://planealo.sytes.net',
        ],
        'urlManager' => [
            'hostInfo' => $isLocal ? 'http://localhost' : 'https://planealo.sytes.net',
            'baseUrl' => $isLocal ? '' : 'https://planealo.sytes.net',
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
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD
                    ],
                ],
                /*'dmstr\web\AdminLteAsset' => [
                'skin' => 'skin-black',
                ], */   
            ],
        ],
    ],
    'modules' => [
        'atletas' => [
            'class' => 'app\modules\atletas\atletas',
        ],
        'epcSanAgustin' => [
            'class' => 'app\modules\escuela_club\epcSanAgustin\epcSanAgustin',
        ],
        'escuela_club' => [
            'class' => 'app\modules\escuela_club\escuela_club',
        ],
        'ged' => [
            'class' => 'app\modules\ged\ged',
        ],
        'aportes' => [
            'class' => 'app\modules\aportes\aportes',
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
