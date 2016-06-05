<?php

namespace app\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%stat_visit_details}}".
 *
 * @property integer $id
 * @property integer $vid
 * @property string $current_url
 * @property string $referer_name
 * @property string $referer_keyword
 * @property integer $referer_type
 * @property string $referer_url
 * @property integer $created_at
 * @property integer $updated_at
 */
class StatVisitDetails extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stat_visit_details}}';
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
            [['vid', 'referer_type', 'created_at', 'updated_at'], 'integer'],
            [['referer_url'], 'string'],
            [['current_url'], 'string', 'max' => 500],
            [['referer_name', 'referer_keyword'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vid' => 'Vid',
            'current_url' => '落地页',
            'referer_name' => '来源',
            'referer_keyword' => '关键词',
            'referer_type' => 'Referer Type',
            'referer_url' => '来源页面',
            'viewRefererUrl' => '来源页面',
            'created_at' => 'Created At',
            'createdAt' => '访问时间',
            'updated_at' => 'Updated At',
        ];
    }
    public function getCreatedAt(){
        return date('Y-m-d H:i:s',$this->created_at);
    }
    public function getViewRefererUrl(){
        $url = $this->referer_url;
        $url = chunk_split($url,100,'<br />');
        return $url;
    }
}
