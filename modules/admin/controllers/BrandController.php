<?php

namespace app\modules\admin\controllers;

use app\helpers\UserLogic;
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
        print_r(UserLogic::getApiType0($userName,$ref));
    }
}
