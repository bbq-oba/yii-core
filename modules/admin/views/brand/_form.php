<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use \kartik\switchinput\SwitchInput;
use \yii\web\JsExpression;
use \yii\web\View;
use \app\core\widgets\CoreFileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$formatJs = <<< JS
var formatRepo = function (repo) {
    if (repo.loading) {
        return repo.text;
    }
    var image = '';
    if(repo.brand_logo_full){
        image = '<img src="' + repo.brand_logo_full + '" style="width:50px" />';
    }
    var markup =
'<div class="row">' +
    '<div class="col-sm-1">' + image + '</div>'+
    '<div class="col-sm-3"><b style="margin-left:5px">' + repo.brand_name + '</b></div>' +
    '<div class="col-sm-3">SN:' + repo.brand_store_sn + '</div>' +
'</div>';
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
JS;
$this->registerJs($formatJs, View::POS_HEAD);
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="brand-form box-body">
    <?= $form->field($model, 'sn')->widget(\kartik\widgets\Select2::classname(), [
        'initValueText' => $model->sn,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'ajax' => [
                'url' => \yii\helpers\Url::to(['/admin/brand/get-brand']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('formatRepo'),
            'templateSelection' => new JsExpression('function (brand) {return brand.id;}'),
        ]
    ]);
    ?>
    <?= $form->field($model, 'cn_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'py_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'initial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'A']) ?>

    <?= $form->field($model, 'show_type_name')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::RADIO,
        'items' => $model->showTypeNameItems,
    ]);
    ?>
    <?= $form->field($model, 'logo')->widget(CoreFileInput::classname(), []); ?>

    <?= $form->field($model, 'is_show')->widget(SwitchInput::classname(), [
        'pluginOptions' => [
            'onText' => '是',
            'offText' => '否',
        ]
    ]);
    ?>
</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>


