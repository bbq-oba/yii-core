<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ApiVisitorConfig */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Api Visitor Config');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Visitor Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-visitor-config-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
