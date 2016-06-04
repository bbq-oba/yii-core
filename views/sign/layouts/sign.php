<?php
/**
 * @author oba.ou
 */
use yii\helpers\Html;
use app\core\assets\AppAsset;
\app\helpers\SignAsset::register($this);
/* @var $this \yii\web\View */
/* @var $content string */
\yii\web\YiiAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <?php echo $content;?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
