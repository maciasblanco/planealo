<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db_saime = require __DIR__ . '/db_saime.php';
$db_cne = require __DIR__ . '/db_cne.php';

$config = [
    'id' => 'GED',
    'name' => 'Escuela Polideportiva y Cultural San Agustín',
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
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'seguridad.auth_item',
            'itemChildTable' => 'seguridad.auth_item_child',
            'assignmentTable' => 'seguridad.auth_assignment',
            'ruleTable' => 'seguridad.auth_rule',
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
        'db_saime' => $db_saime,
        'db_cne' => $db_cne,
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
                'dmstr\web\AdminLteAsset' => [
                'skin' => 'skin-black',
                ],    
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ]
    ],
    'modules' => [
        //rbac security
        'admin' => [
            'class' => 'mdm\admin\Module',
            //'layout' => 'left-menu',
            //'mainLayout' => '@app/views/layouts/mainAdminlte.php',
        ],
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
        'prueba' => [
            'class' => 'app\modules\prueba\prueba',
        ],   

        
    ],
    'params' => $params,
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            /*'site/logout',
            'site/index',
            'site/error',
            'site/sidebar',
            'site/contact',
            'site/about',
            'site/*',
            'municipio/get-by-edo',
            'parroquia/get-by-muni',
            'admin/user/signup',
            'admin/user/request-password-reset',
            'admin/user/reset-password',
            'ged/*',
            'atletas/*',
            'admin/user/*',*/

           '*', // Solo descomentar para hacer prubas del sistema
        ]
    ],
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
