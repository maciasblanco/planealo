<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

// Detección más robusta del entorno
$host = $_SERVER['HTTP_HOST'] ?? '';
$isLocal = (strpos($host, 'localhost') !== false || 
            strpos($host, '127.0.0.1') !== false || 
            strpos($host, '.local') !== false);

$config = [
    'id' => 'GED',
    'name' => 'Gestión de Escuelas Deportivas',
    'language' => 'es',
    'timeZone' => 'America/Caracas',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'main',
    //'defaultRoute' => 'site/login',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'components' => [
        'request' => [
            'cookieValidationKey' => 'mjbvsistemas-ged-voleibol-06012025',
            'baseUrl' => $isLocal ? '' : '',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,    // ✅ Cambiado a true
            'showScriptName' => false,    // ✅ Ahora esto funciona correctamente
            'rules' => [
                // Puedes agregar reglas personalizadas aquí si las necesitas
            ],
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
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'atletas' => [
            'class' => 'app\modules\atletas\Atletas',
        ],
        'epcSanAgustin' => [
            'class' => 'app\modules\escuela_club\epcSanAgustin\EpcSanAgustin',
        ],
        'escuela-club' => [  // ✅ Usando guión en lugar de underscore
            'class' => 'app\modules\escuela_club\EscuelaClub',
        ],
        'ged' => [
            'class' => 'app\modules\ged\Ged',
        ],
        'aportes' => [
            'class' => 'app\modules\aportes\aportes',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;