<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ApiMonthCronSetting */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Api Month Cron Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Month Cron Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-month-cron-setting-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
