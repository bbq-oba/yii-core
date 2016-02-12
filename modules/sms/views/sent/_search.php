<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\SentSmsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sent-sms-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SmsIndex') ?>

    <?= $form->field($model, 'PhoneNumber') ?>

    <?= $form->field($model, 'SmsContent') ?>

    <?= $form->field($model, 'SmsTime') ?>

    <?= $form->field($model, 'SmsUser') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'NewFlag') ?>

    <?php // echo $form->field($model, 'UserDefineNo') ?>

    <?php // echo $form->field($model, 'SentSetIndex') ?>

    <?php // echo $form->field($model, 'RM1') ?>

    <?php // echo $form->field($model, 'RM2') ?>

    <?php // echo $form->field($model, 'RM3') ?>

    <?php // echo $form->field($model, 'RecvReportTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
