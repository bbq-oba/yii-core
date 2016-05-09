<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use app\helpers\ArrayDataProvider;
use app\helpers\Page;
use app\helpers\RegUser;
use app\modules\admin\models\ApiVisitorDetail;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;
use app\modules\admin\models\VisitsDetails;

class StatController extends \yii\web\Controller
{
    public function actionCron($type,$num){
        \app\models\ApiVisitorDetail::cronUpdateVisitorDataType($type,$num,5);
        return $this->render('cron');
    }

    public function actionTest($user,$type,$ref){
        foreach(RegUser::$typeEnum as $k=>$v){
            echo "---  用戶名:$user  --  $k-$v[0]    ---------------\r\n";
            print_r(RegUser::get($user,$k,$ref));
            echo "\r\n";
        }
    }

//    public function actionUpdateRegUser(){
//        $params['filter_offset'] = max(0,\yii::$app->request->get('filter_offset',0));
//        $params['filter_limit'] = 20;
//        $params['segment'] = 'userId!=';
//        if(!empty($visitorId)){
//            $params['segment'] = 'visitorId=='.$visitorId;
//        }
//        $data = API::run('Live.getLastVisitsDetails',$params);
//        $this->format($data);
//        $this->redirect(['reg-user','filter_offset'=>$params['filter_offset']]);
//    }

    public function actionRegUserLebao(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(1);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => \yii::$app->request->get('filter_limit',50),
            ],
        ]);

        return $this->render($model->render,[
            'title'=>'乐宝注册',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }


    public function actionRegUserYonglihui(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(2);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => \yii::$app->request->get('filter_limit',50),
            ],
        ]);

        return $this->render($model->render,[
            'title'=>'永利汇注册',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }
//    public function actionRegUserOther(){
//        $model  = new VisitsDetails();
//        $model->load(\yii::$app->request->queryParams);
//
//        $data = $model->search(4);
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => $data,
//            'pagination' => [
//                'pageSize' => $model->filter_limit,
//            ],
//        ]);
//
//        return $this->render($model->render,[
//            'title'=>'无注册源',
//            'dataProvider' => $dataProvider,
//            'model' =>$model
//        ]);
//    }



//    public function actionCommonUser(){
//        $model  = new VisitsDetails();
//        $model->load(\yii::$app->request->queryParams);
//
//        $data = $model->search(3);
//
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => $data,
//            'totalCount'=>1000,
//            'pagination' => [
//                'pageSize' => \yii::$app->request->get('filter_limit',50),
//            ],
//        ]);
//        return $this->render($model->render,[
//            'title'=>'未注册',
//            'dataProvider' => $dataProvider,
//            'model' =>$model
//        ]);
//    }

    public function actionCommonUser(){
        $model = new \app\models\VisitForm();
        $model->load(\yii::$app->request->queryParams);
        $model->initSearch();
        $count = $model->search('VisitsSummary.getVisits');
        $model->initPage();
        $data = $model->search('Live.getLastVisitsDetails');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'totalCount'=>isset($count['value']) ? $count['value'] : 0 ,
            'pagination' => [
                'pageSize' =>$model->pageSize,
            ],
        ]);
        return $this->render('common-user',[
            'title'=>'未注册',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }

}
