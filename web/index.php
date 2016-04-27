<?php
require(__DIR__ . '/../config/define.php');

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', isset($_GET['DEBUG']));
defined('YII_ENV') or define('YII_ENV', isset($_GET['DEBUG']) ? 'dev': 'prod');
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
$config = require(__DIR__ . '/../config/web.php');
(new yii\web\Application($config))->run();
