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
        ApiVisitorDetail::cronUpdateVisitorDataType($type);
    }


//    //名称  更新时间  接口路径 ， 每次更新条数
//    public static $typeEnum  = [
//        0 => ['所属推广号',0,'api/Extension/ReferralCode',100],
//        1 => ['用户首存金额',86400,'api/Extension/FirstDepositAmount',100],
//        2 => ['用户首存优惠',0,'api/Extension/FirstDepositBonus',100],
//        3 => ['用户存款笔数',86400,'api/Extension/DepositCount',100],
//        4 => ['登录时间',3600,'api/Extension/LastLogin',100],
//        5 => ['成功提款次数',86400,'api/Extension/WithdrawalCount',100],
//        6 => ['会员投注信息',43200,'',100],
//        7 => ['未存款之前领取的优惠',86400,'',100],
//        8 => ['所有优惠',86400,'',100],
//    ];

    public function actionIndex($limit = 100)
    {
        set_time_limit(0);
        ApiVisitorDetail::cronInsert($limit);
        ApiVisitorDetail::cronUpdateIptext($limit);




//        ApiVisitorDetail::cronUpdateIptype($limit);



//        for ($i = 0 ; $i<=5 ; $i++) {
//            ApiVisitorDetail::cronUpdateVisitorDataType($i, $limit, RegUser::$typeEnum[$i][1]);
//        }

        ApiVisitorDetail::cronUpdateVisitorDataType(0); //推广号

        ApiVisitorDetail::cronUpdateVisitorDataType(1); //首存金额

        ApiVisitorDetail::cronUpdateVisitorDataType(3); //首存金额




    }
    public function actionTest(){
           \yii::info(date('Y-m-d H:i;s'),'con');
    }
}
