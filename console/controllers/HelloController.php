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
    public function actionIndex($message = 'hello world')
    {
        ApiVisitorDetail::cronInsert(1);
//        ApiVisitorDetail::cronUpdateIptext(1);
//        ApiVisitorDetail::cronUpdateIptype(1);


     //     ApiVisitorDetail::cronUpdateVisitorDataType(3,1,3);





//        ApiVisitorDetail::cronUpdateVisitorDataType(1,100,0);
//        ApiVisitorDetail::cronUpdateVisitorDataType(2,100,0);
//        ApiVisitorDetail::cronUpdateVisitorDataType(3,100,0);
//        ApiVisitorDetail::cronUpdateVisitorDataType(4,100,0);
//        ApiVisitorDetail::cronUpdateVisitorDataType(5,100,0);
//        ApiVisitorDetail::cronUpdateVisitorDataType(6,100,0);
//        ApiVisitorDetail::cronUpdateVisitorDataType(7,100,0);
//        ApiVisitorDetail::cronUpdateVisitorDataType(8,100,0);
        echo $message . "\n";
    }
    public function actionTest(){
           \yii::info(date('Y-m-d H:i;s'),'con');
    }
}
