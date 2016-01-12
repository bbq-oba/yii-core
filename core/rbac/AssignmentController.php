<?php
/**
 * @author oba.ou
 */

namespace app\core\rbac;


use app\models\User;
use Yii;
use mdm\admin\models\searchs\Assignment as AssignmentSearch;

class AssignmentController extends \mdm\admin\controllers\AssignmentController
{

    public $idField = 'id';
    public $userClassName = '\app\models\User';



    public function actionIndex()
    {

        if ($this->searchClass === null) {
            $searchModel = new AssignmentSearch;
            $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams(), $this->userClassName, $this->usernameField);
        } else {
            $class = $this->searchClass;
            $searchModel = new $class;
            $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        }

        return $this->render('@app/core/rbac/views/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'extraColumns' => $this->extraColumns,
        ]);
    }




    /**
     * Search roles of user
     * @param  integer $id
     * @param  string  $target
     * @param  string  $term
     * @return string
     */
    public function actionSearch($id, $target, $term = '')
    {
        $return = parent::actionSearch($id, $target, $term);
        //非超超超级管理员，不可以分配Super权限
        if(!User::checkIsSuperAdmin() && $return && isset($return['Roles']) && isset($return['Roles']['super'])){
            unset($return['Roles']['super']);
        }
        return $return;
    }
}