<?php

namespace app\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%api_month_detail}}".
 *
 * @property string $id
 * @property string $idvisit
 * @property string $mtime
 * @property string $visitor_datatype_9
 * @property string $visitor_datatype_10
 * @property string $visitor_datatype_12
 * @property string $visitor_datatype_11
 * @property string $updated_datatype_9
 * @property string $updated_datatype_10
 * @property string $updated_datatype_11
 * @property string $updated_datatype_12
 * @property string $visitor_username
 * @property integer $visitor_referrer
 * @property string $created_at
 * @property string $updated_at
 */
class ApiMonthDetail extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_month_detail}}';
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
            [['idvisit', 'mtime', 'updated_datatype_10', 'updated_datatype_11', 'updated_datatype_12', 'updated_datatype_13', 'visitor_referrer', 'created_at', 'updated_at'], 'integer'],
            [[ 'visitor_datatype_10','visitor_datatype_11', 'visitor_datatype_12', 'visitor_datatype_13', 'visitor_username'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idvisit' => 'Idvisit',
            'mtime' => 'Mtime',
            'visitor_datatype_10' => 'Visitor Datatype 10',
            'visitor_datatype_11' => 'Visitor Datatype 11',
            'visitor_datatype_12' => 'Visitor Datatype 12',
            'visitor_datatype_13' => 'Visitor Datatype 13',

            'updated_datatype_10' => 'Updated Datatype 10',
            'updated_datatype_11' => 'Updated Datatype 11',
            'updated_datatype_12' => 'Updated Datatype 12',
            'updated_datatype_13' => 'Updated Datatype 13',

            'visitor_username' => 'Visitor Username',
            'visitor_referrer' => 'Visitor Referrer',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function xBatchInsert($array){
        return static::getDb()->createCommand()->batchInsert('api_month_detail', [
            'idvisit',
            'mtime',
            'visitor_username',
            "visitor_referrer",
            'created_at'
        ],$array)->execute();
    }



}
