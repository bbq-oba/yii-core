<?php
/**
 * @author oba.ou
 */

$obj = new \app\core\helpers\CtrlActionsHelper(\yii::$app);
$array = $obj->getArray();
$options = [];
foreach ($array as $moduleName=>$module) {
    $optionLabel = $module['id'];
    $data = [];
    foreach ($module['controllers'] as $controllerName => $controller) {
        foreach ($controller['actions'] as $action=>$actionName ) {
            $key = strtolower('/'.$moduleName.'/'.$controllerName.'/'.$action);
            $data[$key] = $actionName.'[ '.$key.' ]';
        }
    }
    if($data){
        $data = array_merge([
            strtolower('/'.$optionLabel)=>$optionLabel
        ],$data);
        $options[$optionLabel] = $data;
    }
}



echo $form->beginField($node,'selectController');
echo \yii\helpers\Html::activeLabel($node, 'selectController');
echo \kartik\select2\Select2::widget([
    'name' => 'selectController',
    'value'=> $node->url,
 //   'language' => 'zh-CN',
    'data' => $options,
    'options' => ['placeholder' => '选择控制器'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        "change" =>'function(){var url = this.value;var name = this.options[this.selectedIndex].text.split("[")[0]; $("#systemmenu-url").val(url);$("#systemmenu-name").val(name)}',
    ]
]);
echo $form->endField();

echo $form->field($node, 'url')->textInput();
?>


