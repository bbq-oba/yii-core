<?php
use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use \app\modules\admin\Module;
use kartik\helpers\Html;
?>
<?php $form = ActiveForm::begin([
    'type'=>ActiveForm::TYPE_INLINE,
    'method'=>'get',
    'options' =>
        [
            'enctype' => 'multipart/form-data',
            'style' =>'float:left;margin-top:7px;',
        ]
]);

echo DateRangePicker::widget([
    'attribute'=>"date",
    'name'=>'date',
    'value'=>\app\api\core\API::formatDate(),
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
?>

<div style="display: inline-block">
<?php
echo \kartik\widgets\Select2::widget([
    'name' => 'filter_limit',
    'value' => \yii::$app->request->get('filter_limit',50),
    'data' => [
        20=>20,
        50=>50,
        100=>100,
        200=>200,
    ],
    'options' => [
        'placeholder' => '每页条数',
    ]
]);
?>
</div>
<?= Html::submitButton('ok', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
