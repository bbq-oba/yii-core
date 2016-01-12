<?php
/**
 * @author oba.ou
 */
namespace app\core\models;

use Yii;
use \app\core\models\Model;
use \app\core\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%admin_config}}".
 *
 * @property string $id
 * @property string $option_key
 * @property string $option_value
 * @property string $option_text
 * @property string $create_time
 * @property integer $creater
 * @property integer $is_deleted
 * @property string $update_time
 */
class AdminConfig extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_config}}';
    }

     /*
      * 更新时间
      */
     public function behaviors()
     {
         return [
             [
                 'class' => TimestampBehavior::className(),
                 'createdAtAttribute' => 'create_time',
                 'updatedAtAttribute' => 'update_time',
                 'value' => Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s'),
             ],
         ];
     }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'integer'],
            [['creater','option_key', 'option_value', 'option_text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'option_key' => '键',
            'option_value' => '值',
            'option_text' => '说明',
            'create_time' => '添加时间',
            'creater' => '创建人',
            'is_deleted' => '是否删除,0=》正常，1=》已删除',
            'update_time' => '更新时间',
        ];
    }
    public function beforeSave($insert){
        $this->creater = yii::$app->user->identity->username;
        return parent::beforeSave($insert);
    }

    public $key ;
    public function init(){
        $this->key =  SERVER_ENV_PREFIX.':admin_config:';
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if($changedAttributes && isset($changedAttributes['option_key'])){
            yii::$app->redis->hdel($this->key,$changedAttributes['option_key']);
        }
        yii::$app->redis->hset($this->key,$this->option_key,$this->option_value);
    }
    public function afterDelete(){
        parent::afterDelete();
        yii::$app->redis->hdel($this->key,$this->option_key);
    }

}
