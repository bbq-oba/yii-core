<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\modules\sms\models\ModemTable;

/* @var $this yii\web\View */
/* @var $modelapp\modules\sms\models\SendingSms*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="sending-sms-form box-body">

    <?php
    $modem = ModemTable::find()->where([
        "ModemState"=>"启用"
    ])->asArray()->all();

    $modemValue = \yii\helpers\ArrayHelper::getColumn($modem,"ModemIndex");

    $modemKey = array_map(function($val){
        return substr($val,-2) * 1;
    },$modemValue);

    $modenArray = array_combine($modemKey,$modemValue);

    echo $form->field($model, 'SendModem')->widget(\kartik\widgets\Select2::classname(), [
        'data' => $modenArray,
        'options' => ['placeholder' => '默认设备'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

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

