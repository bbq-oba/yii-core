<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\console\controllers;
use app\helpers\RegUser;
use app\models\ApiVisitorDetail;
use yii\console\Controller;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionUser($type){
        ApiVisitorDetail::cronUpdateVisitorDataType($type,1,5);
    }
    public function actionIndex($limit = 100)
    {
        set_time_limit(0);
        ApiVisitorDetail::cronInsert($limit);
        ApiVisitorDetail::cronUpdateIptext($limit);
        ApiVisitorDetail::cronUpdateIptype($limit);
        for ($i = 0 ; $i<=5 ; $i++) {
            ApiVisitorDetail::cronUpdateVisitorDataType($i, $limit, RegUser::$typeEnum[$i][1]);
        }

    }
    public function actionTest(){
           \yii::info(date('Y-m-d H:i;s'),'con');
    }
}
