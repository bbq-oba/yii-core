<?php

namespace app\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%api_visitor_config}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $name
 * @property integer $limit
 * @property string $time
 * @property string $from
 * @property integer $to
 * @property string $where
 * @property string $order
 * @property integer $range
 * @property string $url
 * @property integer $is_closed
 */
class ApiVisitorConfig extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_visitor_config}}';
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
            [['type', 'limit', 'time', 'from', 'to', 'range', 'is_closed'], 'integer'],
            [['from'], 'required'],
            [['name', 'where', 'order', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'name' => '名称',
            'limit' => '更新数量',
            'time' => '更新频率',
            'from' => '开始时间',
            'to' => '结束时间',
            'where' => 'Where',
            'order' => 'Order',
            'range' => '范围',
            'url' => '接口地址',
            'is_closed' => 'Is Closed',
        ];
    }

    public static function cache($forceUpdate = false){
        $key = "api_visitor_config";
        $return = \yii::$app->cache->get($key);

        if($return == null || $forceUpdate){
            $data = self::find()->where([
                'is_closed' => 0
            ])->asArray()->all();

            $return =ArrayHelper::index($data,"type");

            \yii::$app->cache->set($key,$return);
        }
        return $return;
    }



    public function afterSave($insert, $changedAttributes)
    {
        self::cache(1);
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
    public function afterDelete()
    {
        self::cache(1);
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }



}
