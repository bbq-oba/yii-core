<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\models\ApiMonthDetail*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="api-month-detail-form box-body">

        <?= $form->field($model, 'idvisit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mtime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_13')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_11')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_12')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_13')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_11')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_12')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_referrer')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

