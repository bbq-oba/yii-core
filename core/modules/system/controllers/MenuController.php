<?php
/**
 * @author oba.ou
 */
namespace app\core\modules\system\controllers;
use yii\web\Controller;


/**
 * Class DefaultController
 * @package backend\modules\system\controllers
 * @name 系统菜单
 */
class MenuController extends Controller
{

    /**
     * @name 菜单管理
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
