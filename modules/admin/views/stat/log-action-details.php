<?php if($actions):?>


<?php
//$array = [];
//foreach($actions as $action){
//    $action['count'] = 1;
//    if(isset($array[$action['pageIdAction']])){
//        $array[$action['pageIdAction']]['count']++;
//    }else{
//        $array[$action['pageIdAction']] = $action;
//    }
//}
?>


<table class="table">
    <thead>
        <th>链接地址</th>
        <th>访问时间</th>
        <th>页面标题</th>
    </thead>
    <tbody>
    <?php foreach($actions as $action):?>
    <tr>
        <td><?=$action['url']?></td>
        <td><?= isset($action['serverTimePretty']) ? $action['serverTimePretty'] : '';?></td>
        <td><?= isset($action['pageTitle']) ? $action['pageTitle'] : '';?></td>
    </tr>
    </tbody>
    <?php endforeach;?>
</table>
<?php else:?>
    无
<?php endif;?>
