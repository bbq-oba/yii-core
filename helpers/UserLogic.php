<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/7
 * Time: 22:32
 */

namespace app\helpers;


use app\models\ApiVisitorConfig;
use app\models\ApiVisitorDetail;
use app\models\StatLogVisit;

use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class UserLogic extends BaseLogic
{

    public static $typeEnum  = [
        0 => ['所属推广号','api/Extension/ReferralCode'],
        1 => ['用户首存金额','api/Extension/FirstDepositAmount'],
        2 => ['用户首存优惠','api/Extension/FirstDepositBonus'],
        3 => ['用户存款笔数','api/Extension/DepositCount'],
        4 => ['登录时间','api/Extension/LastLogin'],
        5 => ['成功提款次数','api/Extension/WithdrawalCount'],
        6 => ['会员投注信息',' api/Extension/BetAmount'],
        7 => ['未存款之前领取的优惠'],
        8 => ['所有优惠'],
    ];




    public $config = [];

    public function init(){
        set_time_limit(0);
        $config = ApiVisitorConfig::cache(1);

        foreach($config as $k=>$v){
            if(!$v['range']){
                $this->config[$k] = $v;
            }
        }

        parent::init();
    }

    public function go($limit=100){
        self::cronInsert($limit);
        self::cronUpdateIptext($limit);
        foreach($this->config as $type =>$config){
            $this->cronVisitorDataType($type);
        }
    }



    /*
     * 更新ip归属地
     * */
    public static function cronUpdateIptext($limit = 100){
        $data = ApiVisitorDetail::find()->where([
            'iptext' => NULL
        ])->andWhere('ip IS NOT NULL')->orderBy('created_at desc')->limit($limit)->all();

        foreach($data as $k=>$model){
            $iptext = IP::find($model->ip); //如果返回false 说明接口数据有问题
            $model->iptext = implode(' ',$iptext);
            $model->update();
        }
    }



    //批量插入新数据
    public static function cronInsert($num = 100){
        $data = StatLogVisit::getNewRecord($num);
        return self::InsertRecord($data);
    }
    public static function InsertRecord($data){
        if($data){
            $array = [];
            foreach($data as$k=>$v){
                $array[$v['idvisit']] = [
                    $v['idvisit'],
                    $v['idvisitor'],                //idvisitor
                    $v['user_id'],                  //user_id
                    $v['custom_var_v2'],             //来源
                    IP::binaryToStringIP($v['location_ip']),               //ip
                    0,               //ip
                    $v['custom_var_v1']
                ];

            }

//            \yii::error(var_export($array,1));
            //查找所有已经存在的记录
            $batchInsert = [];
            if($array){
                $findAll = ApiVisitorDetail::find()->where([
                    'in','idvisit',array_keys($array)
                ])->asArray()->all();

                if($findAll){
                    $findAll = ArrayHelper::index($findAll,'idvisit');
                    $batchInsert = array_diff_key($array,$findAll);
                }else{
                    $batchInsert = $array;
                }
                $idvisits = ArrayHelper::getColumn($batchInsert,0,false);
                StatLogVisit::updateAll([
                    'status' =>1
                ],['idvisit'=>$idvisits]);
                ApiVisitorDetail::xBatchInsert($batchInsert);
            }
            return count($batchInsert);
        }
    }




    //  visitor_datatype_0
    public function cronVisitorDataType($type){

        if(!isset($this->config[$type])){
            return ;
        }

        $config  = $this->config[$type];

        $fields = 'visitor_datatype_'.$type;
        $update = 'updated_datatype_'.$type;

        $where = $config['where'] ? $config['where'] : '1=1';
        $order = $config['order'] ? $config['order'] : 'created_at asc';
        $limit = $config['limit'] ? $config['limit'] : 100;


        $models = ApiVisitorDetail::find()->where($where)->orderBy($order)->limit($limit)->all();

        //连续5次失败则不更新
        $i = 0;
        foreach($models as $k=>$model){
            $userName = $model->visitor_username;
            $ref = $model->visitor_referrer;
            $params = [
                'userName' => $userName ,
            ];
            $return = $this->getByType($ref,$type,$params);
//            $return = [
//                'code' =>200 ,
//                'data' =>'a'
//            ];
            if($return['code'] == 200){
                $model->$fields = $return['data'];
                $model->$update = CURRENT_TIMESTAMP;

                if(!$model->update()){
                    print_r($model->errors);
                }else{
                    \yii::$app->controller->stdout(sprintf("%s - %s:%s Id:%d \n",$userName , $config['name'] , $return['data'],$model->id), Console::BOLD);
                }
            }else{
                $i++;
                if($i>5){
                    break;
                }
            }
        }
    }

}
