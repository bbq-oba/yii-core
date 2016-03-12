<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\modules\sms\models\SentSms*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="sent-sms-form box-body">

        <?= $form->field($model, 'PhoneNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SmsContent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SmsTime')->textInput() ?>

    <?= $form->field($model, 'SmsUser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'NewFlag')->textInput() ?>

    <?= $form->field($model, 'UserDefineNo')->textInput() ?>

    <?= $form->field($model, 'SentSetIndex')->textInput() ?>

    <?= $form->field($model, 'RM1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RM2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RM3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RecvReportTime')->textInput(['maxlength' => true]) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

