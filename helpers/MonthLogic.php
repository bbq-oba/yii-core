<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/13
 * Time: 22:51
 */

namespace app\helpers;


use app\models\ApiMonthDetail;
use app\models\ApiMonthSetting;
use app\models\ApiVisitorConfig;
use app\models\ApiVisitorDetail;
use app\models\ApiVisitorRangeDetail;
use app\models\StatLogVisit;
use yii\helpers\ArrayHelper;

class MonthLogic extends BaseLogic
{

    public $config;
    public function init(){
        set_time_limit(0);
        $config = ApiVisitorConfig::cache(1);
        //只要月更新的配置
        $this->config = [];
        foreach($config as $k=>$v){
            if($v['range']){
                $this->config[] = $v;
            }
        }

        parent::init();
    }



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
     * 7.后台记录月份是否更新 更新多少条，总共多少条，便于记录是否需要全部重新更新一次
     * */
    public $time;
    //初始化所有数据为0
    //如果更新当前月份,不用初始化,强制更新往期数据需要更新,更新往期
    public function _init($forceUpdate = false){
        if($forceUpdate){
            ApiVisitorDetail::updateAll(['month_cron' => $this->time]);
        }
    }


    public function reset(){
        $this->start();
        $this->_init(true);
    }

    public function go(){
        $this->start();
        $this->getUpdate(2);
    }

    //查找需要更新的条目
    public function start(){
        $model = new ApiMonthSetting;
        $model = $model->getUpdating();
        $this->time = $model->status;
    }



    public function getUpdate($limit = 100){
        $array = ApiVisitorDetail::find()->where([
            'month_cron'=>$this->time
        ])->orderBy('visitor_regtime asc')->limit($limit)->all();


        $fromTime = date('Y-m-d H:i:s',$this->time);

        $y = date('Y',$this->time);
        $m = date('m',$this->time);

        $toTimeStamp = mktime(0,0,0,$m + 1,1,$y);

        $toTime = date('Y-m-d H:i:s',$toTimeStamp);



        foreach($array as $k=>$v){
            //查找月表是否有该数据，有则不存储
            //逐条获取api 获取完后 数据更新完毕


            $model = ApiMonthDetail::find()->where([
                'idvisit' =>$v['idvisit'],
                'mtime' => $this->time
            ])->one();

            if($model == null){
                $model = new ApiMonthDetail();
            }


            $model->idvisit = $v->idvisit;
            $model->mtime = $this->time;

            $model->visitor_username =  $v->visitor_username;
            $model->visitor_referrer = $v->visitor_referrer;
            $model->created_at = CURRENT_TIMESTAMP;


            $params = [
                'userName' =>  $v->visitor_username ,
                'fromTime' => $fromTime,
                'toTime'   => $toTime,
            ];



            foreach($this->config as $type => $config){
                $fieldName = 'visitor_datatype_'.$type;
                $timeName =  'updated_datatype_'.$type;
                $fieldReturn = $this->get($v['visitor_referrer'],$type,$params);
                print_r($fieldReturn);
                if($fieldReturn['code'] == 200){
                    $model->{$fieldName} = $fieldReturn['data'];
                    $model->{$timeName} = CURRENT_TIMESTAMP;
                }
            }
            print_r($model->attributes);

            if($model->save()){
                $v->month_cron = 0;
                $v->save();
            };

        }
    }


}