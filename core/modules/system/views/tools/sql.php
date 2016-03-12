<?php
/**
 * @author oba.ou
 */

use \kartik\tabs\TabsX;

$this->title = 'SQL Tool';
$this->params['breadcrumbs'][] = $this->title;


$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-home"></i> 执行SQL',
        'content'=>$this->render('sql-query',['sql' => $sql, 'result' => $result]),
        'active'=>true
    ],
];




?>

<div class="box box-danger">
    <div class="box-body">
        <?=TabsX::widget([
            'items'=>$items,
            'position'=>TabsX::POS_ABOVE,
            'align'=>TabsX::ALIGN_RIGHT,
            'bordered'=>true,
            'encodeLabels'=>false
        ]);?>
    </div>
</div>
