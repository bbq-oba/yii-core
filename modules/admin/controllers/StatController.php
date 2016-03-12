<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use app\helpers\Page;
use app\modules\admin\models\ApiVisitorDetail;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
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
        $data = $this->getDb($data);
print_r($data);
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('reg-user',[
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdateRegUser(){
        $params['filter_offset'] = max(0,\yii::$app->request->get('filter_offset',0));
        $params['filter_limit'] = 20;
        $params['segment'] = 'userId!=';
        if(!empty($visitorId)){
            $params['segment'] = 'visitorId=='.$visitorId;
        }
        $data = API::run('Live.getLastVisitsDetails',$params);
        $this->format($data);

    }



    public function getDb($data){
        $userArray = [];

        //找到piwik 返回数据的 userId
        foreach($data as $row){
            $userArray[] = $row["userId"];
        }
        $userArray = array_unique($userArray);

        // 在数据库中查找 username
        $find = ApiVisitorDetail::find()->where([
            "in","visitor_username",$userArray
        ])->asArray()->all();
        $array = [];

        //格式化username
        foreach($find as $k=>$v){
            $array[$v["visitor_referrer"]."---".$v["visitor_username"]] = $v;
        }

        //匹配到data中返回
        foreach($data as $k=>$row){
            if(isset($row["customVariables"][2]["customVariableName2"])
                && $row["customVariables"][2]["customVariableName2"] == "regReferrer"
                && isset($row["customVariables"][2]["customVariableValue2"])
                && !empty($row["customVariables"][2]["customVariableValue2"])
                && in_array($row["customVariables"][2]["customVariableValue2"],array_keys(ApiVisitorDetail::$referrerType))
                && in_array($row["customVariables"][2]["customVariableValue2"]."---".$row["userId"],array_keys($array))
            ){
                $data[$k] = array_merge($row,$array[$row["customVariables"][2]["customVariableValue2"]."---".$row["userId"]]);
            }
        }

        return $data;
    }

    public function format($data){
        $array = [];
        foreach($data as $row){
            if(
                isset($row["customVariables"][2]["customVariableName2"])
                && $row["customVariables"][2]["customVariableName2"] == "regReferrer"
                && isset($row["customVariables"][2]["customVariableValue2"])
                && !empty($row["customVariables"][2]["customVariableValue2"])
//                && in_array($row["customVariables"][2]["customVariableValue2"],array_keys(ApiVisitorDetail::$referrerType))
            ){
                $array[$row["customVariables"][2]["customVariableValue2"]][] = $row["userId"];
            }
        }

print_r($data);
print_r($array);
        if($array){
            $api = new ApiVisitorDetail();
            foreach($array as $referrer => $userArray){
                $api->getUserAllData(array_unique($userArray),$referrer);
            }
        }
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
