#!/usr/bin/env php
<?php
/**
 * Yii console bootstrap file.
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);

define('YII_ROOT',dirname(dirname(__DIR__)));


echo file_exists(YII_ROOT . '/vendor/autoload.php');exit;

require(YII_ROOT . '/vendor/autoload.php');
require(YII_ROOT . '/vendor/yiisoft/yii2/Yii.php');

$config = (YII_ROOT . '/config/console.php');

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);




