<?php

namespace app\modules\sms\models;

use Yii;
use \app\core\models\Model;
use \app\core\behaviors\TimestampBehavior;
/**
 * This is the model class for table "recvsmstable".
 *
 * @property integer $SmsIndex
 * @property string $SmsTime
 * @property string $SendNumber
 * @property string $SmsContent
 * @property string $RecvModemSet
 * @property integer $NewFlag
 * @property string $SendTime
 * @property string $SMSCID
 */
class Recvsmstable extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recvsmstable';
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
            [['SmsTime', 'SendTime'], 'safe'],
            [['NewFlag'], 'integer'],
            [['SendNumber', 'RecvModemSet', 'SMSCID'], 'string', 'max' => 50],
            [['SmsContent'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SmsIndex' => 'Sms Index',
            'SmsTime' => '接收时间',
            'SendNumber' => '发送号码',
            'SmsContent' => '短信内容',
            'RecvModemSet' => '短信设备序号',
            'NewFlag' => 'New Flag',
            'SendTime' => '短信发送的时间',
            'SMSCID' => 'Smscid',
        ];
    }
}
