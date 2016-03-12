<?php
$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;
/**
 * @author oba.ou
 */
// VIEW - views/product/index.php
echo \kartik\tree\TreeView::widget([
    'query' => \app\core\models\SystemMenu::find()->addOrderBy('root, lft , sort'),
    'headingOptions' => ['label' => '菜单管理'],
    'rootOptions' => ['label'=>'<span class="text-primary">顶级栏目</span>'],
    'fontAwesome' => true,
    'isAdmin' => false,
    'displayValue' => 1,
    'softDelete' => false,
    'cacheSettings' => ['enableCache' => true],
    'showIDAttribute'=>false,
    'nodeAddlViews' => [
        \kartik\tree\Module::VIEW_PART_1 => '@app/core/modules/system/views/menu/menu-form',
    ],
]);