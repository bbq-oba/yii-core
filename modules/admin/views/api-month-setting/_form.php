<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\models\ApiMonthDetail*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="api-month-detail-form box-body">

    <?= $form->field($model, 'time')->dropDownList(\app\helpers\MonthLogic::getMonth()) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

