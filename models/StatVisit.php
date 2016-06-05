<?php

namespace app\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stat_visit}}".
 *
 * @property integer $id
 * @property string $idvisitor
 * @property string $location_ip
 * @property integer $status
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
 * @property integer $updated_datatype_9
 * @property integer $visitor_referrer
 * @property integer $iptype
 * @property string $iptext
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $visitor_regtime
 * @property string $month_cron
 */
class StatVisit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stat_visit}}';
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
            [['idvisitor', 'location_ip','flag'], 'required'],
            [['status', 'updated_datatype_0', 'updated_datatype_1', 'updated_datatype_2', 'updated_datatype_3', 'updated_datatype_4', 'updated_datatype_5', 'updated_datatype_6', 'updated_datatype_7', 'updated_datatype_8', 'updated_datatype_9', 'visitor_referrer', 'iptype', 'updated_at', 'created_at', 'visitor_regtime', 'month_cron'], 'integer'],
            [['idvisitor'], 'string', 'max' => 32],
            [['location_ip', 'visitor_username', 'visitor_datatype_0', 'visitor_datatype_1', 'visitor_datatype_2', 'visitor_datatype_3', 'visitor_datatype_4', 'visitor_datatype_5', 'visitor_datatype_6', 'visitor_datatype_7', 'visitor_datatype_8', 'visitor_datatype_9', 'iptext'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idvisitor' => '标识',
            'location_ip' => 'IP',
            'status' => 'Status',
            'visitor_username' => '用户名',
            'visitor_datatype_0' => '所属推广号',
            'visitor_datatype_1' => '用户首存金额',
            'visitor_datatype_2' => '用户首存优惠',
            'visitor_datatype_3' => '用户存款笔数',
            'visitor_datatype_4' => '登录时间',
            'visitor_datatype_5' => '提款次数',
            'visitor_datatype_6' => 'Visitor Datatype 6',
            'visitor_datatype_7' => '未存款优惠次数',
            'visitor_datatype_8' => '未存款优惠金额',
            'visitor_datatype_9' => '注册网址',
            'updated_datatype_0' => 'Updated Datatype 0',
            'updated_datatype_1' => 'Updated Datatype 1',
            'updated_datatype_2' => 'Updated Datatype 2',
            'updated_datatype_3' => 'Updated Datatype 3',
            'updated_datatype_4' => 'Updated Datatype 4',
            'updated_datatype_5' => 'Updated Datatype 5',
            'updated_datatype_6' => 'Updated Datatype 6',
            'updated_datatype_7' => 'Updated Datatype 7',
            'updated_datatype_8' => 'Updated Datatype 8',
            'updated_datatype_9' => '注册域名',
            'visitor_referrer' => '注册源',
            'iptype' => 'IP类型',
            'iptext' => 'IP归属地',
            'flag' => 'js标识',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'createdAt' => 'Created At',
            'visitor_regtime' => '注册时间',
            'month_cron' => 'Month Cron',
            'info' => '推广信息',
            'youhui' => '未存款优惠',
        ];
    }

    public function getCreatedAt()
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }

    public function getInfo()
    {
        $return = [];
        $return[] = '注册时间:'. date('Y-m-d H:i:s',$this->visitor_regtime);
        $return[] = '注册来源:'. $this->visitor_referrer;
        $return[] = '注册域名:'. $this->visitor_datatype_9;
        $return[] = '推　广号:'. $this->visitor_datatype_0;
        $return[] = '首存金额:'. $this->visitor_datatype_1;
        $return[] = '存款次数:'. $this->visitor_datatype_3;
        return implode('<br />',$return);
    }
    public function getYouhui(){
        $return = [];
        $return[] = '次数:'. $this->visitor_datatype_7;
        $return[] = '金额:'. $this->visitor_datatype_8;
        return implode('<br />',$return);
    }
    public function getViewRefrrer(){


    }
}
