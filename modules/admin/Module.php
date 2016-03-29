<?php

namespace app\modules\admin;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();
//        self::setCommonSessionArray(self::getCommonSession());
    }
//    public static function setCommonSession($idSite,$from = '',$to = ''){
//        if(empty($from)){
//            $from = $to = CURRENT_DATE;
//        }elseif(empty($to)){
//            $to = $from;
//        }
//        self::setCommonSessionArray([
//            'idSite'=>$idSite,
//            'from'=>$from,
//            'to'=>$to
//        ]);
//    }
//    public static function setCommonSessionArray($params){
//        if($params['from'] == $params['to']){
//            $date = $params['from'];
//            $period = 'day';
//        }else{
//            $date = $params['from'].','.$params['to'];
//            $period = 'range';
//        }
//        \yii::$app->session['idSite'] = $params['idSite'];
//        \yii::$app->session['date'] = $date;
//        \yii::$app->session['period'] = $period;
//    }
//    public static function getCommonSession(){
//        if(isset(\yii::$app->session['date'])){
//            $date = \yii::$app->session['date'];
//            if(strpos($date,',')){
//                list($from,$to) = explode(',',$date);
//                $period = 'range';
//            }else{
//                $from = $to = $date;
//                $period = 'day';
//            }
//        }else{
//            $from = $to = CURRENT_DATE;
//            $period = 'day';
//        }
//        return [
//            'idSite' => DEFAULT_ID_SITE,
//            'from' =>$from,
//            'to' => $to,
//            'period' => $period
//        ];
//    }
}
