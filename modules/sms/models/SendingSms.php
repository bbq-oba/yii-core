<?php

namespace app\modules\sms\models;

use Yii;

/**
 * This is the model class for table "sendingsmstable".
 *
 * @property integer $SmsIndex
 * @property string $SmsUser
 * @property string $PhoneNumber
 * @property string $SmsContent
 * @property integer $UserDefineNo
 * @property string $PutInType
 * @property integer $SendLevel
 * @property integer $SendModem
 * @property integer $NewFlag
 * @property string $RM1
 * @property string $RM2
 * @property string $RM3
 */
class SendingSms extends \yii\db\ActiveRecord
{
    public $phone;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sendingsmstable';
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
            [["phone","SmsContent"],"required"],
            [['UserDefineNo', 'SendLevel', 'SendModem', 'NewFlag'], 'integer'],
            [['SmsUser', 'PutInType'], 'string', 'max' => 50],
            [['PhoneNumber'], 'number', 'min' => 11],
            [['SmsContent'], 'string', 'max' => 200],
            [['RM1', 'RM2', 'RM3'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SmsIndex' => 'Sms Index',
            'SmsUser' => 'Sms User',
            'PhoneNumber' => '手机号码',
            'SmsContent' => '发送内容',
            'UserDefineNo' => 'User Define No',
            'PutInType' => 'Put In Type',
            'SendLevel' => 'Send Level',
            'SendModem' => 'Send Modem',
            'NewFlag' => 'New Flag',
            'RM1' => 'Rm1',
            'RM2' => 'Rm2',
            'RM3' => 'Rm3',
        ];
    }
    public function send(){
        $phone = preg_split("/\r\n/",$this->phone);
        $phone = array_filter($phone);
        $phone = array_unique($phone);
        $array = [];
        foreach($phone as $p){
            if(preg_match("/\d{11}/",$p)){
                $array[] = [$p,$this->SmsContent];
            }
        }
        if ($array){
            return static::getDb()->createCommand()->batchInsert('sendingsmstable', ['PhoneNumber', 'SmsContent'],$array)->execute();
        }
        return true;
    }

}
