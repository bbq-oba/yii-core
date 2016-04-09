<?php

namespace app\modules\admin\controllers;

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
    public function actionIndex($userName,$ref){
        print_r(UserService::get($ref,0,['userName'=>$userName]));
    }

    public function actionTest(){
//        $cache = ApiVisitorConfig::cache(1);

        (new UserLogic())->go();

       return $this->render('test');
    }
}
