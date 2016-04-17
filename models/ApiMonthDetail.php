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
            [['idvisit', 'mtime', 'updated_datatype_9', 'updated_datatype_10', 'updated_datatype_11', 'updated_datatype_12', 'visitor_referrer', 'created_at', 'updated_at'], 'integer'],
            [['visitor_datatype_9', 'visitor_datatype_10', 'visitor_datatype_12', 'visitor_datatype_11', 'visitor_username'], 'string', 'max' => 255]
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
            'visitor_datatype_9' => 'Visitor Datatype 0',
            'visitor_datatype_10' => 'Visitor Datatype 1',
            'visitor_datatype_12' => 'Visitor Datatype 2',
            'visitor_datatype_11' => 'Visitor Datatype 3',
            'updated_datatype_9' => 'Updated Datatype 0',
            'updated_datatype_10' => 'Updated Datatype 1',
            'updated_datatype_11' => 'Updated Datatype 2',
            'updated_datatype_12' => 'Updated Datatype 3',
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
