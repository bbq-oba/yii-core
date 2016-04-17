<?php

namespace app\modules\admin\controllers;

use app\helpers\MonthLogic;
use app\helpers\UserLogic;
use app\helpers\UserService;
use app\models\ApiVisitorConfig;
use Yii;
use app\models\Brand;
use app\models\BrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\behaviors\TimestampBehavior;
use yii\web\Response;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
{
    public function actionIndex($userName,$ref,$type){
	    $obj = new UserLogic();
        print_r($obj->get($ref,$type,['userName'=>$userName]));
    }

    public function actionTest(){
//        $cache = ApiVisitorConfig::cache(1);

        (new UserLogic())->go();

       return $this->render('test');
    }


    public function actionMonth(){
        $m = new MonthLogic();
        $m->reset();
        $m->go();
        return $this->render('test');
    }
}
