<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\models\ApiMonthCronSetting*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="api-month-cron-setting-form box-body">

    <?= $form->field($model, 'time')->dropDownList(\app\helpers\MonthCron::getMonth()) ?>

    <?php
        echo $model->status ? ('正在更新'.date('Y年m月数据，耗时较长请等待更新完毕',$model->status)) : '更新完毕';
    ?>

</div>

<?php if(!$model->status):?>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php endif;?>
<?php ActiveForm::end(); ?>

