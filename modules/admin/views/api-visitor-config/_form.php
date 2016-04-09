<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\models\ApiVisitorConfig*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="api-visitor-config-form box-body">

        <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'limit')->textInput() ?>

    <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to')->textInput() ?>

    <?= $form->field($model, 'where')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'range')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

