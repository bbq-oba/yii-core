<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\modules\sms\models\ModemTable;

/* @var $this yii\web\View */
/* @var $modelapp\modules\sms\models\SendingSms */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="sending-sms-form box-body">
    <?= $form->field($model, 'host'); ?>
    <?= $form->field($model, 'port'); ?>
    <?= $form->field($model, 'dbname'); ?>
    <?= $form->field($model, 'user'); ?>
    <?= $form->field($model, 'pass'); ?>
</div>

<div class="box-footer">
    <?= Html::submitButton("保存", ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<pre>
<?php
print_r(\yii::$app->smsdb);
?>
</pre>