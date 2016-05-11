<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;

/* @var $this yii\web\View */
/* @var $model app\models\BrandSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin(
    [
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'method' => 'get',
        'options' => [
            'class' => 'col-sm-5'
        ]
    ]
);
echo FormGrid::widget([
    'model' => $model,
    'form' => $form,
    'columnSize' => Form::SIZE_TINY,
    'autoGenerateColumns' => true,
    'rows' => [
        [
            'attributes' => [       // 2 column layout
                'from' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DatePicker', 'options' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]],
                'to' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DatePicker', 'options' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]],
            ]
        ],
        [
            'attributes' => [       // 1 column layout
                'userId' => ['type' => Form::INPUT_TEXT,],
                'visitorId' => ['type' => Form::INPUT_TEXT,],
            ],
        ],
        [
            'attributes' => [       // 1 column layout
                'pageSize' => [
                    'type' => Form::INPUT_TEXT],
                    'options' => [
                        'name' => 'per-page'
                    ],
                ],
                'actions' => [    // embed raw HTML content
                    'type' => Form::INPUT_RAW,
                    'value' => '<div style="text-align: right;">' .
                        Html::a('重置','/'.\yii::$app->request->pathInfo, ['class' => 'btn btn-default']) . ' ' .
                        Html::submitButton('搜索', ['class' => 'btn btn-primary']) .
                        '</div>'
                ],
            ],
        ],
    ]
]);
ActiveForm::end();
?>
