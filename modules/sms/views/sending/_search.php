<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\SendingSmsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sending-sms-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SmsIndex') ?>

    <?= $form->field($model, 'SmsUser') ?>

    <?= $form->field($model, 'PhoneNumber') ?>

    <?= $form->field($model, 'SmsContent') ?>

    <?= $form->field($model, 'UserDefineNo') ?>

    <?php // echo $form->field($model, 'PutInType') ?>

    <?php // echo $form->field($model, 'SendLevel') ?>

    <?php // echo $form->field($model, 'SendModem') ?>

    <?php // echo $form->field($model, 'NewFlag') ?>

    <?php // echo $form->field($model, 'RM1') ?>

    <?php // echo $form->field($model, 'RM2') ?>

    <?php // echo $form->field($model, 'RM3') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
