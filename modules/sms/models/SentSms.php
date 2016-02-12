<?php

namespace app\modules\sms\models;

use Yii;

/**
 * This is the model class for table "sentsmstable".
 *
 * @property integer $SmsIndex
 * @property string $PhoneNumber
 * @property string $SmsContent
 * @property string $SmsTime
 * @property string $SmsUser
 * @property integer $Status
 * @property integer $NewFlag
 * @property integer $UserDefineNo
 * @property integer $SentSetIndex
 * @property string $RM1
 * @property string $RM2
 * @property string $RM3
 * @property string $RecvReportTime
 */
class SentSms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sentsmstable';
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
            [['SmsTime'], 'safe'],
            [['Status', 'NewFlag', 'UserDefineNo', 'SentSetIndex'], 'integer'],
            [['PhoneNumber', 'SmsUser', 'RecvReportTime'], 'string', 'max' => 50],
            [['SmsContent', 'RM1', 'RM2', 'RM3'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SmsIndex' => 'Sms Index',
            'PhoneNumber' => '手机号',
            'SmsContent' => '内容',
            'SmsTime' => '时间',
            'SmsUser' => 'Sms User',
            'Status' => '状态',
            'NewFlag' => 'New Flag',
            'UserDefineNo' => 'User Define No',
            'SentSetIndex' => 'Sent Set Index',
            'RM1' => 'Rm1',
            'RM2' => 'Rm2',
            'RM3' => 'Rm3',
            'RecvReportTime' => 'Recv Report Time',
        ];
    }
    public static $status = [
        '失败','成功'
    ];
   public function getViewStatus(){
       return self::$status[$this->Status];
   }
}
