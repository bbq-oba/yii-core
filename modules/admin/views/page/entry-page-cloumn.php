<?php


    $html = "";
    foreach($data as $k=>$v){
        $id = "_".md5(implode(",",$v));
        $idsubdatatable = "";
        if(isset($v['idsubdatatable'])){
            $idsubdatatable = '<i onclick="getSubData(\''.$id.'\','.$v['idsubdatatable'].','.$lvl.')" class="fa fa-fw fa-plus-square-o"></i>';
            $v['label'] = "<b>".$v['label']."</b>";
        }else{

        }
        $html .= '<tr class="'.$id.'">';
            $html .="<td></td>";
            $html .="<td>".str_repeat("　",$lvl).$idsubdatatable.$v['label']."</td>";
            $html .="<td>".$v['entry_nb_visits']."</td>";
            $html .="<td>".$v['entry_bounce_count']."</td>";
            $html .="<td>".$v['bounce_rate']."</td>";
            $html .= "<td></td>";
        $html .= "</tr>";
        if(isset($v['idsubdatatable'])){
            $html.= '<tr class="hide" id="'.$id.'"><th style="width: 10px"></th><td colspan="6" id="'.$id.'-loading"></td></tr>';
        }
    }
    echo $html;
?>