<?php
/**
 * @author oba.ou
 */
namespace app\core\models;
use kartik\helpers\Html;
use Yii;
class Model extends \yii\db\ActiveRecord{
    public function delete(){
        $this->is_deleted = 1;
        $this->save();
    }
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        \yii::$app->session->setFlash('success',($insert ? Yii::t('app', 'Create')    : Yii::t('app', 'Update')) . "成功" .Html::icon('smile-o'));
    }
    public function afterDelete(){
        parent::afterDelete();
        \yii::$app->session->setFlash('success',"删除成功");
    }
}