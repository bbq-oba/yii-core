<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/31
 * Time: 21:41
 */

namespace app\stat;


use app\models\StatVisit;
use app\models\StatVisitDetails;

class Visit
{

    public function setCookie($defaultCookies = false){
        if(!$defaultCookies){
            list($usec, $sec) = explode(" ", microtime());
            $time = $sec.$usec;
            $visit = md5(uniqid().'----'.$time.'----'.rand(100000,999999));
        }else{
            $visit = $defaultCookies;
        }
        $cookies = \yii::$app->getResponse()->getCookies();
        $cookies->add(new \yii\web\Cookie([
            'name' => 'visit',
            'value' => $visit,
            'expire' => 86400 * 30 * 30 + time(),
        ]));
        return $visit;
    }

    public static function findVisitor($idvisitor)
    {
        $row = StatVisit::find()->where(['idvisitor' => $idvisitor])->one();
        return $row;
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


    public function getIdvisitor(){
        $cookies = \yii::$app->request->cookies;
        if ($cookies->has('visit')) {
            $visitCookie = $cookies->getValue('visit');
            $this->setCookie($visitCookie);
        } else {
            $visitCookie = $this->setCookie();
        }
        return $visitCookie;
    }

    public static function getIp()
    {
        return self::getIpString();
    }

    /**
     * @return mixed|string
     * @throws Exception
     */
    public static function getIpString()
    {
        $cip = \yii::$app->request->get('cip');
        if (empty($cip)) {
            return \app\stat\IP::getIpFromHeader();
        }
        return $cip;
    }

    public function load($idvisitor,$referrers){
        $request = \yii::$app->request;
        return array_merge([
            'idvisitor'=>$idvisitor,
            'location_ip' =>$this->getIp(),
            'visitor_username' => $request->get('ru'),
            'visitor_regtime' => $request->get('rt') ? CURRENT_TIMESTAMP : 0,
            'visitor_referrer' => $request->get('rr' , 0),
            'last_visit_time' => CURRENT_TIMESTAMP
        ],$referrers);
    }

    public function tracker(){
        $idvisitor = $this->getIdvisitor();

        if(!$model = $this->findVisitor($idvisitor)){
            $model = new StatVisit();
        }
        $referrers = new Referrers();
        $details = $referrers->getReferrerInformationFromRequest();

        $model->load([
            'StatVisit'=>$this->load($idvisitor,$details)
        ]);
        $model->save();
        if($model->id){
            $details['vid'] = $model->id;
            $details['flag'] = \yii::$app->request->get('rf' , 1);
            $this->insertVisitDetails($details);
        }

    }
}