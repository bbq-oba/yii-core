<?php
/**
 * @author oba.ou
 */

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\core\models\AdminConfig */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Admin Config');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-config-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
