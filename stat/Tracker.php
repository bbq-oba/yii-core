<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/24
 * Time: 21:56
 */

namespace app\stat;


use app\models\StatLogVisit;
use app\models\StatVisit;
use app\models\StatVisitDetails;
use yii\base\Exception;
use yii\di\Container;

class Tracker
{
    const LENGTH_HEX_ID_STRING = 16;
    const LENGTH_BINARY_ID = 8;


    public function findKnownVisitor($params)
    {
        $configId = $params['config_id'];
        $idSite = $params['idsite'];
        $idVisitor = $params['idvisitor'];

        $visitRow = self::findVisitor($idSite, $configId, $idVisitor);
        return $visitRow;
    }

    public function insertNewVisitor($params)
    {

        $model = new StatVisit();
        $model->load([
            'StatVisit' => $params
        ]);
        if (!$model->save()) {
            echo "StatVisit";
            print_r($model->errors);
        }
        return $model;
    }

    public function insertVisitDetails($params)
    {
        $model = new StatVisitDetails();
        $model->load([
            'StatVisitDetails' => $params
        ]);
        if (!$model->save()) {
            echo "StatVisitDetails";
            print_r($model->errors);
        }
        return $model;
    }


    public static function findVisitor($idSite, $configId, $idVisitor)
    {
        $row = StatVisit::find()->where(['config_id' => $configId])->andWhere(['idsite' => $idSite])->one();
        return $row;
    }


    public function setCookie($name, $value, $expire)
    {

    }


    public function process()
    {



//exit;
//
//
//        $request = new Request();
//        $params = $request->processVisit();
//
//        $model = $this->findKnownVisitor($params);
//
//        if(!$model){
//            $model = $this->insertNewVisitor($params);
//        }
//
//        $this->insertVisitDetails($request->processVisitDetails($model->id));
//
//
//        exit;


    }

}