<?php

namespace app\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%captcha_code}}".
 *
 * @property string $id
 * @property integer $code
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $mobile
 * @property string $content
 */
class CaptchaCode extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%captcha_code}}';
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
            [['code', 'created_at', 'updated_at', 'status'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['content'], 'string' , 'max'=>500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'mobile' => 'Mobile',
        ];
    }

    public static function insertCode($mobile,$code,$content){
        $model = new self;
        $model->mobile = $mobile;
        $model->code = $code;
        $model->content = $content;
        $model->status = 0;
        $model->save();
    }
}
