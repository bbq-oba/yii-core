<?php
/**
 * @author oba.ou
 */
namespace app\core\cas;

use app\core\models\User;

class WebUser extends \yii\web\User
{
    public $isGuest;


    public function getIsGuest()
    {
        $this->isGuest = !\phpCAS::isAuthenticated() || \yii::$app->user->identity == null;
        return $this->isGuest;
    }

    /**
     * @param \app\core\models\User $identity
     * @param bool $cookieBased
     * @param int $duration
     */
    public function afterLogin($identity, $cookieBased, $duration){

        $user = User::findIdentity($identity->user_id);

        if($user){
            //更新已存在用户
        }else{
            //保存新用户
            $user = new User();
            $user->attributes = $identity->attributes;
            $user->save();
        }
    }

}