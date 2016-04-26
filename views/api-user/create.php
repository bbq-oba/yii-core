<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ApiUser */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Api User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-user-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
