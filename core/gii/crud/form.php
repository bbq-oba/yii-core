<?php
/**
 * @author oba.ou
 */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */
echo '<div class="panel panel-danger"><div class="panel-heading">选择下列3项</div><div class="panel-body">';


$field = $form->field($generator,'modelClassHelper');
$field->parts['{input}'] = \kartik\select2\Select2::widget([
    'model' => $generator,
    'attribute' => 'modelClassHelper',
    'data' => $generator->modelClassHelperData,
    'options' => [
        'placeholder' => '选择Model',
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        "change" =>'function(){
            var val = this.options[this.selectedIndex].text;

            $("#generator-modelclass").val(val);

            $("#generator-searchmodelclass").val(val+"Search");

            $("#generator-helpfield").val(this.value);
         }',
    ]
]);
echo $field;
$field = $form->field($generator,'controllerNameSpaceHelper');
$field->parts['{input}'] = \kartik\select2\Select2::widget([
    'model' => $generator,
    'attribute' => 'controllerNameSpaceHelper',
    'data' => $generator->controllerNameSpaceHelperData,
    'options' => [
        'placeholder' => '选择生成位置',
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        "change" =>'function(){
            var namespace = this.options[this.selectedIndex].text;

            var temp = $("#generator-helpfield").val().split("|");

            var controller = namespace +"\\\"+ temp[0] + "Controller";

            $("#generator-controllerclass").val(controller);

            var viewPath = (namespace.substring(0,namespace.length-11)+ "views\\\" +temp[1]).replace(/\\\\/g,\'/\');

            $("#generator-viewpath").val("@"+viewPath);

         }',
    ]
]);
echo $field;

$field = $form->field($generator,'messageCategory');
$field->parts['{input}'] = \kartik\select2\Select2::widget([
    'model' => $generator,
    'attribute' => 'messageCategory',
    'data' => $generator->messageCategoryData,
    'options' => [
        'placeholder' => '选择语言包',
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],

]);
echo $field;
echo '</div></div>';
//echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'helpField')->hiddenInput()->label(false)->error(false);
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);

