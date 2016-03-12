<?php
/**
 * @author oba.ou
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\models\AdminConfig */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Admin Config', [
    'modelClass' => 'Admin Config',
]) . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="admin-config-update box box-danger">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
