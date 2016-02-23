<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\modules\sms\models\SendingSms*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="sending-sms-form box-body">


    <?= $form->field($model, 'phone')->textarea([
        'rows'=>15
    ]) ?>

    <?= $form->field($model, 'SmsContent')->textarea(['rows' => 5]) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

