<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\models\StatVisit*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="stat-visit-form box-body">

        <?= $form->field($model, 'idvisitor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'visitor_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_0')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitor_datatype_9')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_0')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_datatype_9')->textInput() ?>

    <?= $form->field($model, 'visitor_referrer')->textInput() ?>

    <?= $form->field($model, 'iptype')->textInput() ?>

    <?= $form->field($model, 'iptext')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'visitor_regtime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'month_cron')->textInput(['maxlength' => true]) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

