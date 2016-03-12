<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'basic',
    'name'=>'统计',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'language'=>'zh-CN',
    'controllerNamespace' => 'app\stat\controllers',
    'timeZone' => 'Asia/Shanghai',
    'charset' => 'utf-8',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'aqqQh-xgur1SpKA6fgl3GpbVs2pFxHpH8Vn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
}
return $config;
