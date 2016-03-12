<?php

namespace app\modules\admin\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%api_visitor_detail}}".
 *
 * @property integer $id
 * @property string $visitor_username
 * @property string $visitor_datatype_0
 * @property string $visitor_datatype_1
 * @property string $visitor_datatype_2
 * @property integer $visitor_datatype_3
 * @property integer $visitor_referrer
 */
class ApiVisitorDetail extends Model
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
            [['visitor_datatype_1', 'visitor_datatype_2', 'visitor_datatype_3', 'visitor_referrer'], 'integer'],
            [['visitor_username', 'visitor_datatype_0'], 'string', 'max' => 255]
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
        ];
    }

    public function getUserAllData($userArray,$referrer = 1){
        $userString = implode(",",$userArray);
        $typeArray = [0,1,2,3];
        $data = [];
        foreach($typeArray as $type){
            $return = self::getUserData($userString,$type,$referrer);
            if($return["IsSuccess"] && $return["Result"]){
                foreach($return["Result"] as $k => $val){
                    $data[$val["UserName"]]["visitor_datatype_".$type] = $val["Result"];
                }
            }
        }
        print_r($data);
        foreach($data as $user=>$val){
            $data[$user]["visitor_username"] = $user;
            $data[$user]["visitor_referrer"] = $referrer;

            $model = new ApiVisitorDetail();
            $find = ApiVisitorDetail::findone([
                'visitor_username'=>$user,
                'visitor_referrer'=>$referrer
            ]);



            if ($find){
                $model = $find;
            }

            $array = [
                "ApiVisitorDetail" =>array_merge([
                    'visitor_username'=>$user,
                    'visitor_referrer'=>$referrer,
                ],$val)
            ];
            $model->load($array);
print_r($model->attributes);
            $model->save();
        }








    }

    public static $referrerType = [
        1 => 'lbvbet',
        2 => 'wyvbet',
    ];
    public static function getUserData($userName,$userDataType,$referrer = 1){
        $fields=array(
            'userName'=>$userName, //用户名,多个用户以逗号分隔,必填
            'userDataType'=>$userDataType, //要获取的用户数据类型,必填（所属推广号：0，用户首存金额：1，用户首存优惠：2，用户存款笔数：3）
            'signKey'=>'604A0B84-FBAD-4B45-AF2D-E1F848CD543F', //不用修改
            'lastLoginStartTime'=>'', //最后登录开始时间,选填
            'lastLoginEndTime'=>'', //最后登录结束时间,选填
            'datatype'=>'json' //返回数据类型 xml or json
        );
        $fields=http_build_query($fields);

        $url='http://'.self::$referrerType[$referrer].'.gallary.work/api/user/GetUserData?'.$fields;
        /**
         * 不得使用 file_get_contents();
         */
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, 10); //默认等待10 超时
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        $json=curl_exec($ch);

        if($json===false){
            $json=curl_error($ch);
            var_dump($json);
            die('系统报错，请修复');
        }
        curl_close($ch);
        $array=json_decode($json,true);
        return $array;
    }
}
