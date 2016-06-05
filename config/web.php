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
    'timeZone' => 'Asia/Shanghai',
    'charset' => 'utf-8',
    'modules' => [
        'treemanager'   =>  ['class' => '\kartik\tree\Module'],             //树
        'system'        =>  ['class' => '\app\core\modules\system\Module'],  //公用系统组件
        'admin'         =>  ['class' => '\app\modules\admin\Module'],       //后台管理
        'gridview'      =>  ['class' => '\kartik\grid\Module'],             //grid
        'rbac'          =>  [                                               //授权
            'class' => '\mdm\admin\Module',
            'layout' => '@app/core/views/layouts/main-box',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'app\core\rbac\AssignmentController',
                ]
            ],
        ],
        'sms' => [
            'class' => 'app\modules\sms\Module',
        ],
    ],
    'as access' => [
        'class' => 'app\core\rbac\AccessControl',
        'allowActions' => [
            'site/login',
            'site/error',
            'sign/*',
            'stat/index',
            'stat/test',
        ]
    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/core/views'
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dc660dc8322c37d46e3dc670f4b0368f',
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
//            'class' => 'app\core\rbac\DbManager',
//            'defaultRoles' => ['unauthorized'],//添
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-red',
                ],
            ],
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
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app'=>'app.php',
                        'column' => 'column.php',
                    ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'smsdb'=>require(__DIR__ . '/smsdb.php'),
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
        'controllerMap' => [
            'default' => [
                'class' => 'app\core\gii\controllers\DefaultController',
            ]
        ],
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators'=>[
            'oba-crud' => [
                'class' => 'app\core\gii\crud\Generator',
                'generatorControllerPath'=>[
                    'app\controllers',
                    'app\modules\admin\controllers',
                    'app\modules\sms\controllers',
                    'app\core\modules\system\controllers',
                ],
                'modelsPath'=>[
                    '@app/models',
                    '@app/modules/sms/models',
                    '@app/core/models',
                ],
            ],
            'oba-model'=> ['class' => 'app\core\gii\model\Generator']
        ],

    ];
}
return $config;
