<?php

namespace app\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%api_month_detail}}".
 *
 * @property string $id
 * @property string $time
 * @property string $status
 * @property string $updated_count
 * @property string $selected_count
 * @property string $created_at
 * @property string $updated_at
 */
class ApiMonthSetting extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_month_setting}}';
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
            [[ 'status', 'updated_count', 'selected_count', 'created_at', 'updated_at'], 'integer'],
            ['time','validateTime','on'=>['create']],
            ['time','unique','message'=>'该月份已存在']
        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['time'],
            'updating' => ['status'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'viewTime' => '月份',
            'viewIsUpdating' => '状态',
            'status' => '状态',
            'updated_count' => '更新量',
            'selected_count' => '总量',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }




    public function validateTime($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $cyear = date('Y',CURRENT_TIMESTAMP);
            $cMonth = date('m',CURRENT_TIMESTAMP);
            $maxTime = mktime(0,0,0,$cMonth + 1,1,$cyear);

            list($y,$m) = explode('-',$this->$attribute);
            $createTime = mktime(0,0,0,$m,1,$y);

            if($createTime > $maxTime){
                $this->addError($attribute,'还为到可更新的月份');
            }
            $this->$attribute = $createTime;
        }
    }

    public function getViewTime(){
        return date('Y-m',$this->time);
    }

    public function getUpdating(){
        return self::find()->where('status > 0')->one();
    }
    public function getViewIsUpdating(){
        return $this->status ? ' [正在更新]' : '';
    }
    public function updateTheMonth($id){
        if($this->updating > 0){
            \yii::$app->session->setFlash('success',"还有数据尚未更新完成，请稍后");
        }else{
           $model = self::findOne($id);
           $model->setScenario('updating');
           $model->status = $model->time;
           $model->update();
        }
    }
}
