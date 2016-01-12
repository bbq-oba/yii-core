<?php
/**
 * @author oba.ou
 */
namespace app\core\cas;

use Yii;

class phpCas extends \phpCAS //implements IdentityInterface
{
    public static function init(){
        \phpCAS::setDebug('assets/cas.log');
        \phpCAS::client(CAS_VERSION_2_0, CAS_HOST, CAS_PORT, CAS_PATH);
        \phpCAS::setNoCasServerValidation();
    }
    public static function getUser(){
        list($username,$userEmail,$uid) = explode('|',\phpCAS::getUser());
        return $username;
    }
    public static function modelAttributes(){
        $userInfo = array_combine(array('username','email','user_id'),explode('|',\phpCAS::getUser()));
        $casInfo = array_change_key_case(array_map('urldecode',\phpCAS::getAttributes()),CASE_LOWER);
        $casInfo['realname'] = $casInfo['username'];
        unset($casInfo['useraccountcontrol'],$casInfo['usernum'],$casInfo['useremail']);
        $return = array_merge($casInfo,$userInfo);
        return $return;
    }
}