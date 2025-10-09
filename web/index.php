<?php
// HABILITAR DEBUG - TEMPORAL
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
// === SOLUCIÓN LOCALHOST - AGREGAR AL INICIO ===
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    $_SERVER['HTTPS'] = 'off';
    $_SERVER['SERVER_PORT'] = 80;
    
    // Configuración específica para localhost
    $config = require __DIR__ . '/../config/web.php';
    
    // Sobrescribir cualquier configuración que fuerce HTTPS
    if (isset($config['components']['request'])) {
        $config['components']['request']['baseUrl'] = '';
    }
    if (isset($config['components']['urlManager'])) {
        $config['components']['urlManager']['baseUrl'] = '';
    }
    
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
    
    (new yii\web\Application($config))->run();
    exit;
}
// === FIN SOLUCIÓN ===

// ... el resto normal de tu index.php actual
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();
?>