<?php
/**
 * @author oba.ou
 */

namespace app\core\modules\system\controllers;


use app\core\models\RedisManageForm;
use yii\base\Exception;

class ToolsController extends \yii\web\Controller
{

    public function actionIndex()
    {
    }


    public function actionSql()
    {
        $sql = empty($_POST['sql']) ? '' : strip_tags($_POST['sql']);
        $act = empty($_POST['act']) ? '' : trim($_POST['act']);
        $result = '';
        if ($act == 'query') {
            try {
                $sqlStatement = $sql;
                $connection = \yii::$app->db;
                $command = $connection->createCommand($sqlStatement);
                $dataReader = $command->query();
                $data = $dataReader->readAll();
                $result = '';
                if (is_array($data) && isset($data[0]) === true) {
                    $result = "<table class='table table-bordered table-hover dataTable'> \n <tr>";
                    $keys = array_keys($data[0]);
                    for ($i = 0, $num = count($keys); $i < $num; $i++) {
                        $result .= "<th>" . $keys[$i] . "</th>\n";
                    }
                    $result .= "</tr> \n";
                    foreach ($data AS $data1) {
                        $result .= "<tr>\n";
                        foreach ($data1 AS $value) {
                            $result .= "<td>" . $value . "</td>";
                        }
                        $result .= "</tr>\n";
                    }
                    $result .= "</table>\n";
                } else {
                    $result = "<center><h3>数据为空</h3></center>";
                }
            } catch (\yii\db\Exception $e) {
                $errorInfo = $e->errorInfo;
                if ((int)$errorInfo[1] > 0) $result = $e->getMessage();
                else $result = '执行成功';
            }

        }
        $sql = 'select * from '.TABLE_PREFIX.'admin_user limit 10;';
        return $this->render('sql', array('sql' => $sql, 'result' => $result));
    }

    public function actionRedisManage()
    {
        $model = new RedisManageForm();
        $result = '';
        if ($model->load(\yii::$app->request->post()) ) {
            $model->params = preg_split("/\r\n/",$model->params);
            $result  = \yii::$app->redis->executeCommand($model->commands,$model->params);
            $model->params = implode("\r\n",$model->params);
        }
        return $this->render('redis-manage', [
            'model' => $model,
            'result'=>$result
        ]);
    }
}