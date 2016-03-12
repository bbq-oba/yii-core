<?php
/**
 * @author oba.ou
 */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\form\Generator */
echo $form->field($generator, 'tableName')->hiddenInput()->label(false)->error(false)->hint(false);

$field = $form->field($generator,'tableNameHelper');
$field->parts['{input}'] = \kartik\select2\Select2::widget([
    'model' => $generator,
    'attribute' => 'tableNameHelper',
    'data' => $generator->tableNameData,
    'options' => [
        'placeholder' => '选择数据库',
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        "change" =>'function(){
            $("#generator-modelclass").val(this.value);
            var val = this.options[this.selectedIndex].text;
            $("#generator-tablename").val(val);
         }',
    ]
]);
echo $field;






echo $form->field($generator, 'modelClass');

echo $form->field($generator, 'ns');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
echo $form->field($generator, 'generateRelations')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateQuery')->checkbox();
echo $form->field($generator, 'queryNs');
echo $form->field($generator, 'queryClass');
echo $form->field($generator, 'queryBaseClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
