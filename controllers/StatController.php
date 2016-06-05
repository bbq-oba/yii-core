<?php
namespace app\controllers;
use app\helpers\SmsHelper;
use app\models\User;
use app\stat\Tracker;
use app\stat\Visit;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\Response;

class StatController extends Controller
{

    public function actionIndex(){
        (new Visit())->tracker();
    }
}
