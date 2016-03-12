<?php
/**
 * Created by PhpStorm.
 * User: oba.ou
 * Date: 2015/12/24
 * Time: 16:51
 */

define("SERVER_ENV_PREFIX",'WO2365_');
define('TABLE_PREFIX','vip_');
/**
 * CURRENT_TIMESTAMP 定义为当前时间，减少框架调用 time() 的次数
 */
define('CURRENT_TIMESTAMP', $_SERVER['REQUEST_TIME']);
define('CURRENT_DATETIME', date('Y-m-d H:i:s',CURRENT_TIMESTAMP));
define('CURRENT_DATE', date('Y-m-d',CURRENT_TIMESTAMP));

define('STAT_TRACKER_URL','//p.sasa8.com/piwik.php');

define('STAT_API_URL','//p.sasa8.com/piwik.php');
define('STAT_API_TOKEN','c38de7c5e14711949af48b11464d8cba');

define('DEFAULT_ID_SITE',1);
