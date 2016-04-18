<?php

namespace app\models;

use app\helpers\IP;
use app\helpers\IpType;
use app\helpers\RegUser;
use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\log\Logger;

/**
 * This is the model class for table "{{%api_visitor_detail}}".
 *
 * @property integer $id
 * @property string $visitor_username
 * @property string $visitor_datatype_0
 * @property string $visitor_datatype_1
 * @property string $visitor_datatype_2
 * @property string $visitor_datatype_3
 * @property string $visitor_datatype_4
 * @property string $visitor_datatype_5
 * @property string $visitor_datatype_6
 * @property string $visitor_datatype_7
 * @property string $visitor_datatype_8
 * @property string $visitor_datatype_9
 * @property string $updated_datatype_0
 * @property string $updated_datatype_1
 * @property string $updated_datatype_2
 * @property string $updated_datatype_3
 * @property string $updated_datatype_4
 * @property string $updated_datatype_5
 * @property string $updated_datatype_6
 * @property string $updated_datatype_7
 * @property string $updated_datatype_8
 * @property string $updated_datatype_9
 * @property integer $visitor_referrer
 * @property string $ip
 * @property integer $iptype
 * @property string $iptext
 * @property integer $updated_at
 * @property string $idvisitor
 * @property integer $created_at
 * @property string $idvisit
 */
class ApiVisitorDetail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_visitor_detail}}';
    }

     /*
      * 更新时间
      */
     public function behaviors()
     {
         return [
             [
                 'class' => TimestampBehavior::className(),
             ],
         ];
     }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['updated_datatype_0', 'updated_datatype_1', 'updated_datatype_2', 'updated_datatype_3', 'updated_datatype_4', 'updated_datatype_5', 'updated_datatype_6', 'updated_datatype_7', 'updated_datatype_8','updated_datatype_9', 'visitor_referrer', 'iptype', 'updated_at', 'created_at', 'idvisit'], 'integer'],
            [['visitor_username', 'visitor_datatype_0', 'visitor_datatype_1', 'visitor_datatype_2', 'visitor_datatype_3', 'visitor_datatype_4', 'visitor_datatype_5', 'visitor_datatype_6', 'visitor_datatype_7', 'visitor_datatype_8','visitor_datatype_9', 'ip', 'iptext'], 'safe'],
            [['idvisitor'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visitor_username' => 'Visitor Username',
            'visitor_datatype_0' => 'Visitor Datatype 0',
            'visitor_datatype_1' => 'Visitor Datatype 1',
            'visitor_datatype_2' => 'Visitor Datatype 2',
            'visitor_datatype_3' => 'Visitor Datatype 3',
            'visitor_datatype_4' => 'Visitor Datatype 4',
            'visitor_datatype_5' => 'Visitor Datatype 5',
            'visitor_datatype_6' => 'Visitor Datatype 6',
            'visitor_datatype_7' => 'Visitor Datatype 7',
            'visitor_datatype_8' => 'Visitor Datatype 8',
            'updated_datatype_0' => 'Updated Datatype 0',
            'updated_datatype_1' => 'Updated Datatype 1',
            'updated_datatype_2' => 'Updated Datatype 2',
            'updated_datatype_3' => 'Updated Datatype 3',
            'updated_datatype_4' => 'Updated Datatype 4',
            'updated_datatype_5' => 'Updated Datatype 5',
            'updated_datatype_6' => 'Updated Datatype 6',
            'updated_datatype_7' => 'Updated Datatype 7',
            'updated_datatype_8' => 'Updated Datatype 8',
            'updated_datatype_9' => 'Updated Datatype 9',
            'visitor_referrer' => 'Visitor Referrer',
            'ip' => 'Ip',
            'iptype' => 'Iptype',
            'iptext' => 'Iptext',
            'updated_at' => 'Updated At',
            'idvisitor' => 'Idvisitor',
            'created_at' => 'Created At',
            'idvisit' => 'Idvisit',
        ];
    }


    public static function findAllByAttribute($conf,$limit){
        return self::find()->where($conf)->orderBy('created_at desc')->limit($limit)->asArray()->all();
    }





    /*
     * 批量更新ipType，只用执行一次
     *
     * */
    public static function cronUpdateIptype($limit = 100){
        $data = self::find()->where([
            'iptype' => 0
        ])->andWhere('ip IS NOT NULL')->orderBy('created_at desc')->limit($limit)->asArray()->all();

        return self::batchUpdateIptype($data);
    }

    public static function batchUpdateIptype($array){
        if($array){
            foreach($array as $k=>$v){
                $iptype = IpType::find($v['ip']); //如果返回false 说明接口数据有问题
                if($iptype !== false){
                    $data = self::findOne($v['id']);
                    $data->iptype = IpType::find($v['ip']);
                    $data->update();
                }
            }
        }
    }






    //更新推广号 1次

    //TODO: 每个字段对应一个 time_0

    //TODO:

    //TODO: 更新完数据 status = 1

    //TODO:

    /**
     * @param $type
     * @param $limit
     * @param $time
     */

    /**
     * @param string $type 需要更新的数据类型
     * @param int $limit 更新的数据量
     * @param int $time 是否根据时间更新数据，如果时间是0则表示此数据只更新一次
     *                  如果是1800则表示 超过1800秒的数据，更新一次
     */
    public static function cronUpdateVisitorDataType($type,$limit = 100,$time = 0){
        if($time){
         //   $and = CURRENT_TIMESTAMP - '`updated_datatype_'.$type.'``' >$time;
	        $and = sprintf(" %d - `%s` > %d OR `%s` IS NULL ",CURRENT_TIMESTAMP,'updated_datatype_'.$type,$time,'updated_datatype_'.$type);
            $orderBy = 'updated_datatype_'.$type.' asc';
        }else{
            $and = ['visitor_datatype_'.$type=>NULL];
            $orderBy = 'created_at desc';
        }
        $data = self::find()->where($and)->orderBy($orderBy)->limit($limit)->asArray()->all();
        self::batchUpdateVisitorDataType($type,$data,$time);
    }

    public static function batchUpdateVisitorDataType($type,$array,$time){
        if($array){
            $data = [];
            foreach($array as $k=>$v){
                $data[$v['visitor_referrer']][$v['id']] = $v['visitor_username'];
            }
            if($data){
                //如果有数据
                $ret = [];
                foreach($data as $ref => $users){
                    $user = implode(',',$users);
                    $return = RegUser::get($user,$type,$ref);
                    /**
                     * [
                     *      'Username' => 'aaa',
                     *      'Result'   => 'bbb'
                     * ]
                     */
                    if($return["IsSuccess"] && $return["Result"]){
                        foreach($return["Result"] as $k => $val){
                            $ret[array_search($val['UserName'],$users)] = $val["Result"];
                        }
                    }
                }

            }
            foreach($array as $k=>$v){
                $u = self::findOne($v['id']);
                $u->{'visitor_datatype_'.$type} = isset($ret[$v['id']]) ? $ret[$v['id']] : ($time ? NULL : '');
                if($time){
                    $u->{'updated_datatype_'.$type} = CURRENT_TIMESTAMP;
                }
                $u->update();
            }
        }
    }

    //循环更新注册用户信息


    public static function xBatchInsert($array){
        return static::getDb()->createCommand()->batchInsert('vip_api_visitor_detail', [
            'idvisit',
            'idvisitor',
            'visitor_username',
            "visitor_referrer",
            "ip",
            "created_at",
            "visitor_regtime"
        ],$array)->execute();
    }

    //身份标识定义  idvisitor + user_id + custom_var_k2

    public static function makeIndentify($array){
        return md5('indentify_'.implode(',',$array));
    }

    public static function getMonthCronData($time){
        return self::find()->where([
            'month_cron' =>$time
        ])->count();
    }

}
