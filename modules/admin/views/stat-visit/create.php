<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StatVisit */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Stat Visit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stat Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-visit-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
