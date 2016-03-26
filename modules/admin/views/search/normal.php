<?php
use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use \app\modules\admin\Module;
use kartik\helpers\Html;
?>
<?php $form = ActiveForm::begin([
    'type'=>ActiveForm::TYPE_INLINE,
    'action'=>\yii\helpers\Url::to(['/admin/default/date']),
    'options' =>
        [
            'enctype' => 'multipart/form-data',
            'style' =>'float:left;margin-top:7px;'
        ]
]);

$params = Module::getCommonSession();
echo DateRangePicker::widget([
    'attribute'=>"date",
    'name'=>'date',
    'value'=>$params['from'].','.$params['to'],
    'convertFormat'=>true,
    'pluginOptions'=>[
//                'timePicker'=>true,
//                'timePickerIncrement'=>15,
//                'timePicker24Hour'=>true,
        'locale'=>[
            'separator'=>',',
            'format'=>'Y-m-d'
        ],
        'opens'=>'right'
    ],
]);
echo Html::hiddenInput('redirectUrl',yii::$app->request->getAbsoluteUrl());

?>
<?= Html::submitButton('ok', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
