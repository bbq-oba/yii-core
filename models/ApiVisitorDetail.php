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
 * @property integer $visitor_referrer
 * @property string $ip
 * @property integer $iptype
 * @property string $iptext
 * @property integer $updated_at
 * @property string $idvisitor
 * @property string $identify
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
            [['visitor_referrer', 'iptype', 'updated_at'], 'integer'],
            [['visitor_username', 'visitor_datatype_0', 'visitor_datatype_1', 'visitor_datatype_2', 'visitor_datatype_3', 'ip', 'iptext'], 'string', 'max' => 255],
            [['idvisitor'], 'string', 'max' => 8],
            [['identify'], 'string', 'max' => 32]
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
            'visitor_referrer' => 'Visitor Referrer',
            'ip' => 'Ip',
            'iptype' => 'Iptype',
            'iptext' => 'Iptext',
            'updated_at' => 'Updated At',
            'idvisitor' => 'Idvisitor',
            'identify' => 'Identify',
        ];
    }


    public static function findAllByAttribute($conf,$limit){
        return self::find()->where($conf)->orderBy('created_at desc')->limit($limit)->asArray()->all();
    }

    //批量插入新数据
    public static function cronInsert($num = 100){
        $data = StatLogVisit::getNewRecord($num);
        return self::InsertRecord($data);
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



    /*
     * 更新ip归属地
     * */
    public static function cronUpdateIptext($limit = 100){
        $data = self::find()->where([
            'iptext' => NULL
        ])->andWhere('ip IS NOT NULL')->orderBy('created_at desc')->limit($limit)->asArray()->all();
        return self::batchUpdateIptext($data);
    }

    public static function batchUpdateIptext($array){
        if($array){
            foreach($array as $k=>$v){
                $iptext = IP::find($v['ip']); //如果返回false 说明接口数据有问题
                $data = self::findOne($v['id']);
                $data->iptext = implode(' ',$iptext);
                $data->update();
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
            "identify",
            "created_at"
        ],$array)->execute();
    }

    //身份标识定义  idvisitor + user_id + custom_var_k2

    public static function makeIndentify($array){
        return md5('indentify_'.implode(',',$array));
    }

    public static function InsertRecord($data){
        if($data){
            $array = [];
            foreach($data as$k=>$v){
                $indentify = self::makeIndentify([
                    $v['idvisitor'],$v['user_id'],$v['custom_var_v2']
                ]);

                $array[$indentify] = [
                    $v['idvisit'],
                    $v['idvisitor'],                //idvisitor
                    $v['user_id'],                  //user_id
                    $v['custom_var_v2'],             //来源
                    IP::binaryToStringIP($v['location_ip']),               //ip
                    $indentify,               //ip
                    CURRENT_TIMESTAMP,               //ip
                ];

            }
//            \yii::error(var_export($array,1));
            //查找所有已经存在的记录
            $batchInsert = [];
            if($array){
                $findAll = ApiVisitorDetail::find()->where([
                    'in','identify',array_keys($array)
                ])->asArray()->all();

                if($findAll){
                    $findAll = ArrayHelper::index($findAll,'identify');
                    $batchInsert = array_diff_key($array,$findAll);
                }else{
                    $batchInsert = $array;
                }
                $idvisits = ArrayHelper::getColumn($batchInsert,0,false);
                StatLogVisit::updateAll([
                    'status' =>1
                ],['idvisit'=>$idvisits]);
                self::xBatchInsert($batchInsert);
            }
            return count($batchInsert);
        }
    }
}
