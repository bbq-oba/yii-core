<?php

namespace app\modules\sms\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "ModemTable".
 *
 * @property string $ModemIndex
 * @property string $ModemState
 * @property string $ComName
 * @property string $ModemType
 * @property string $ComRate
 * @property string $NumberArea
 * @property string $SendRate
 * @property integer $SendSucceedCount
 * @property integer $SendErrorCount
 * @property integer $MaxSendCount
 * @property string $Remark
 */
class ModemTable extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ModemTable';
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
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('smsdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ModemIndex'], 'required'],
            [['SendSucceedCount', 'SendErrorCount', 'MaxSendCount'], 'integer'],
            [['ModemIndex', 'ModemState', 'ComName', 'ModemType', 'ComRate', 'NumberArea', 'SendRate'], 'string', 'max' => 50],
            [['Remark'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ModemIndex' => 'Modem Index',
            'ModemState' => 'Modem State',
            'ComName' => 'Com Name',
            'ModemType' => 'Modem Type',
            'ComRate' => 'Com Rate',
            'NumberArea' => 'Number Area',
            'SendRate' => 'Send Rate',
            'SendSucceedCount' => 'Send Succeed Count',
            'SendErrorCount' => 'Send Error Count',
            'MaxSendCount' => 'Max Send Count',
            'Remark' => 'Remark',
        ];
    }
}
