<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use app\helpers\Page;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class StatController extends \yii\web\Controller
{



    public function actionCommonUser(){
        $params['filter_offset'] = max(0,\yii::$app->request->get('filter_offset',0));
        $params['filter_limit'] = 20;
        $params['segment'] = 'userId==';

        $visitorId = \yii::$app->request->get("visitorId");
        if(!empty($visitorId)){
            $params['segment'] = 'visitorId=='.$visitorId;
        }
        $data = API::run('Live.getLastVisitsDetails',$params);
//print_r($data);exit;
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('common-user',[
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionRegUser(){

        $params['filter_offset'] = max(0,\yii::$app->request->get('filter_offset',0));
        $params['filter_limit'] = 20;
        $params['segment'] = 'userId!=';
        if(!empty($visitorId)){
            $params['segment'] = 'visitorId=='.$visitorId;
        }
        $data = API::run('Live.getLastVisitsDetails',$params);

        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('reg-user',[
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionVisitorProfile($visitorId){

        $params['segment'] = 'visitorId=='.$visitorId;
        $data = API::run('Live.getVisitorProfile',$params);

        print_r($data);exit;


        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('visitor-profile',[
            'dataProvider' => $dataProvider
        ]);
    }

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
        return $this->render('test'.$a, [
            'data' => $data
        ]);
    }
}
