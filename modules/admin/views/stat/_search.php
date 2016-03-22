<style>
    .search .form-control{ width:300px;}
    .search .form-group{ margin:0 10px;}
</style>
<?php

use kartik\widgets\ActiveForm;
use kartik\helpers\Html;


$form = ActiveForm::begin([
    'method' => 'get',
    'type'=>ActiveForm::TYPE_INLINE,
    'options'=>[
        'class'=>'search'
    ]
]);

if($model->render == 'reg-user'){
    echo $form->field($model, 'userId');

}
echo $form->field($model, 'filter_limit');

echo $form->field($model, 'regdate',[
])->widget(\kartik\daterange\DateRangePicker::classname(),[
    'attribute'=>"regdate",
    'model'=>$model,
    'convertFormat'=>true,
    'pluginOptions'=>[
        'timePicker'=>true,
        'timePickerIncrement'=>15,
        'timePicker24Hour'=>true,
        'locale'=>[
            'separator'=>' 至 ',
            'format'=>'Y-m-d H:i:s'
        ],
//        'format' => 'dd-M-yyyy HH:mm',
        'opens'=>'right'
    ],

]);



echo Html::submitButton("搜索", [
    'class' => 'btn btn-success',
    'name' =>Html::getInputName($model,'do'),
    'value'=>'search'
]);

echo "&nbsp;&nbsp;";
echo Html::submitButton("更新", [
    'class' => 'btn btn-info',
    'name' =>Html::getInputName($model,'do'),
    'value'=>'update'
]);

ActiveForm::end();
?>