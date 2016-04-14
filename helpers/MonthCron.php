<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/13
 * Time: 22:51
 */

namespace app\helpers;


use app\models\ApiMonthCronSetting;
use app\models\ApiVisitorDetail;
use app\models\ApiVisitorRangeDetail;
use app\models\StatLogVisit;

class MonthCron
{

    const UPDATE_ID = 1;
    public static function getMonth(){
        $y = date('Y',CURRENT_TIMESTAMP);
        $m = date('m',CURRENT_TIMESTAMP);
        $data = [];
        for($i = 2; $i <= $m;$i++){
            $date = sprintf("%02d",$i);
            $data[$y.'-'.$date] = $y.'年'.$date.'月';
        }
        return $data;
    }
    //后台设置某月开始执行
    //数据全部设置为 0
    //检索所有为0的数据  检索完毕设置为  2016-04

    //所有检索完毕,后台告知执行完毕



    // 将所有数据设置为 未处理
    // 每次处理1000条数据



    /*
     * 1.后台设置更新月份 time = 201602
     * 2.detail表 将所有数据  处理为 未更新状态
     * 3.从detail表获取数据 N次  每次 100条 插入到月统计表
     * 4.执行计划任务 从接口获取数据后 更新 更新后数据改为已更新状态
     * 5.确保数据唯一 ？ 1 联合主键 2. select not in
     * 6.全部更新完毕 通知后台 time = 0 更新完毕，可以更新其他月份
     *
     * */
    public $time;
    public function start(){
        $model = ApiMonthCronSetting::findOne(self::UPDATE_ID);
        $this->time = $model->time;
    }

    public function init(){
        ApiVisitorDetail::updateAll(['month_cron' => $this->time]);

    }

    public function run(){

    }




    //查询出指定月份需要插入的所有数据
    public function getAllInsertData($month = '',$year = ''){

        $m = $month ? $month : date('m',CURRENT_TIMESTAMP);
        $y = $year ? $year : date('Y',CURRENT_TIMESTAMP);

        $mtime = mktime(0,0,0,$m + 1,1,$y);

        $where = sprintf("user_id IS NOT NULL AND  custom_var_v1 < %d AND custom_var_v2 > 0",$mtime);

        return StatLogVisit::find()->where($where)->orderBy('visit_last_action_time desc')->count();
    }

    //查询指定月份已经插入的数据
    public function getAllInsertedData($month,$year){
        ApiVisitorRangeDetail::find()->where([
            'mtime' => $year.$month
        ])->all();

    }

    //批量插入到数据库

    //批量更新

}