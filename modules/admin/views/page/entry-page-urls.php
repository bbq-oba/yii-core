<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use \app\helpers\Column;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '入口页面';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->timeZone = 'UTC';
?>
<script>
function getSubData(id, idSubtable,lvl) {
    idSubtable = idSubtable || 0;
    var ajaxStatus = true;
    if(ajaxStatus){
        ajaxStatus = false;
        $.ajax({
            type: "get",
            url: '<?=yii::$app->request->absoluteUrl?>',
            data: {
                'idSubtable': idSubtable,
                'lvl':lvl
            },
            dataType: 'html',
            beforeSend: function (XMLHttpRequest) {
                $('#'+id).removeClass('hide');
                $('#'+id+'-loading').html('数据加载中<img src="/css/loading.gif">');
            },
            success: function (data, textStatus) {
                $('#'+id).replaceWith(data);
            },
            complete: function (XMLHttpRequest, textStatus) {
                $('#'+id+'-loading').html('');

                ajaxStatus = true;
            }
        });
    }
}
</script>
<?php
$js = <<<JS
getSubData('init',0,0);
JS;
$this->registerJs($js,\yii\web\View::POS_READY);
?>
<div class="box box-danger">
    <div class="box-body">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>入口页面网址</th>
                <th style="width: 100px">进入次数</th>
                <th style="width: 100px">跳出次数</th>
                <th style="width: 100px">跳出率</th>
                <th style="width: 100px"></th>
            </tr>
            </thead>
            <tbody>
                <tr class="hide" id="init">
                    <th style="width: 10px">#</th>
                    <td id="init-loading" colspan="5"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
