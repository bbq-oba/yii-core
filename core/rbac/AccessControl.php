<?php
/**
 * @author oba.ou
 */
/**
 * Created by PhpStorm.
 * User: oba.ou
 * Date: 2015/12/28
 * Time: 16:50
 */
namespace app\core\rbac;
use app\models\User;

class AccessControl extends \mdm\admin\components\AccessControl
{


    public function beforeAction($action)
    {

        $actionId = $action->getUniqueId();
        $user = $this->getUser();
        if (User::checkIsSuperAdmin()) {
            return true;
        }
        if ($user->can('/' . $actionId)) {
            return true;
        }
        $obj = $action->controller;
        do {
            if ($user->can('/' . ltrim($obj->getUniqueId() . '/*', '/'))) {
                return true;
            }
            $obj = $obj->module;
        } while ($obj !== null);
        $this->denyAccess($user);
    }

}