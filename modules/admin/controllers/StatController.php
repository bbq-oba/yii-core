<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class StatController extends \yii\web\Controller
{

    public function actionIndex(){
        $type = \yii::$app->request->get("type","commonUser");

        $params = [];
//        $params['doNotFetchActions'] = true;
        $params['segment'] =  $type == 'regUser' ?  "userId!=" : "userId==";
        $data = API::run('Live.getLastVisitsDetails',$params);


        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('index',[
            'dataProvider' => $dataProvider
        ]);
    }


//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    //页面标题
    public function actionTitle(){
        $data = API::run('Actions.getPageTitles');
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('title',[
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionEntryPageUrls(){


        if(\yii::$app->request->isAjax){
            $params = [];
            $idSubtable = \yii::$app->request->get('idSubtable',0);
            if($idSubtable){
                $params['idSubtable'] = $idSubtable;
            }
            $data = API::run('Actions.getEntryPageUrls',$params);
            return $this->renderAjax('entry-page-cloumn',[
                'data' => $data,
                'lvl'=>\yii::$app->request->get('lvl',0) + 1
            ]);
        }
        return $this->render('entry-page-urls');
    }
    public function actionTest()
    {
        $params = [];
        $a = \yii::$app->request->get('a',0);
        if($a){
            $params['idSubtable'] = $a;
        }
        $data = API::run('Actions.getEntryPageUrls',$params);
        $data = json_encode($data);
        $a = \yii::$app->request->get('a',0);
//$data = $a;
//sleep(1);
        return $this->render('test'.$a, [
            'data' => $data
        ]);
    }
}
