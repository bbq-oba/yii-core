<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use app\helpers\Page;
use app\helpers\RegUser;
use app\modules\admin\models\ApiVisitorDetail;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\modules\admin\models\VisitsDetails;

class StatController extends \yii\web\Controller
{


    public function actionTest($user,$type,$ref){

        //所属推广号：0，用户首存金额：1，用户首存优惠：2，用户存款笔数：3
        $array = [
            0 => '所属推广号',
            1 => '用户首存金额',
            2 => '用户首存优惠',
            3 => '用户存款笔数',
            4 => '登录时间',
            5 => '成功提款次数',
            6 => '会员投注信息',
            7 => '未存款之前领取的优惠',
            8 => '所有优惠',
        ];

        foreach($array as $k=>$v){
            echo "---  用戶名:$user bianhao 編號:$k-$v    ---------------\r\n";
            print_r(RegUser::get($user,$k,$ref));
            echo "\r\n";
        }
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
        $this->redirect(['reg-user','filter_offset'=>$params['filter_offset']]);
    }

    public function actionRegUserLebao(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(1);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $model->filter_limit,
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
                'pageSize' => $model->filter_limit,
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



    public function actionCommonUser(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(3);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $model->filter_limit,
            ],
        ]);
        return $this->render($model->render,[
            'title'=>'未注册',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }
}
