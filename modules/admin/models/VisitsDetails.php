<?php
namespace app\modules\admin\models;

use app\api\core\API;
use app\helpers\RegUser;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * LoginForm is the model behind the login form.
 */
class VisitsDetails extends Model
{
    public $visitorId;
    public $userId;
    public $filter_offset;
    public $filter_limit;
    public $regdate;
    public $do;
    public $render;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => '用户名',
            'filter_limit' => '每页条数',
            'regdate' => '注册时间',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['visitorId', 'userId', 'filter_offset', 'filter_limit', 'regdate', 'render', 'do'], 'safe'],
        ];
    }

    public function search($type)
    {
        $params = $segment = [];
        if (!empty($this->visitorId)) {
            $segment[] = 'visitorId==' . $this->visitorId;
        }
        switch ($type) {
            case 1://乐宝用户
                $segment[] = 'customVariableValue2==1';
                if ($this->userId) {
                    $segment[] = 'userId==' . $this->userId;
                } else {
                    $segment[] = 'userId!=';                //有用户名的用户
                }
                $this->render = 'reg-user';
                break;
            case 2://永利汇
                $segment[] = 'customVariableValue2==2';
                if ($this->userId) {
                    $segment[] = 'userId==' . $this->userId;
                } else {
                    $segment[] = 'userId!=';                //有用户名的用户
                }
                $this->render = 'reg-user';
                break;
            case 3:
                //未注册用户
                $segment[] = 'userId==';
                $this->render = 'common-user';
                break;
            default:
                //无注册源的用户
                $segment[] = 'customVariableValue2=='; //
                if ($this->userId) {
                    $segment[] = 'userId==' . $this->userId;
                } else {
                    $segment[] = 'userId!=';                //有用户名的用户
                }
                $this->render = 'reg-user';
        }




        if (!empty($this->regdate) && strpos($this->regdate, " 至 ")) {   //如果有选择日期
            list($startTime, $endTime) = explode(" 至 ", $this->regdate);
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $params['formatDate'] = false;   //去掉默认的date查询

            $segment[] = 'customVariableValue1>=' . $startTime;
            $segment[] = 'customVariableValue1<=' . $endTime;

        }

        $params['segment'] = implode(';', $segment);


        $data = API::run('Live.getLastVisitsDetails' , $params);

        if ($this->render == 'reg-user') {
            $data = $this->getDb($data);
        }
        if ($this->do == 'update') {
            $this->format($data);
        }
        return $data;
    }

    public function format($data)
    {
        $array = [];
        foreach ($data as $row) {
            if (
                isset($row["customVariables"][2]["customVariableName2"])
                && $row["customVariables"][2]["customVariableName2"] == "regReferrer"
                && isset($row["customVariables"][2]["customVariableValue2"])
                && !empty($row["customVariables"][2]["customVariableValue2"])
            ) {
                $array[$row["customVariables"][2]["customVariableValue2"]][] = $row["userId"];
            }
        }

        if ($array) {
            $api = new ApiVisitorDetail();
            foreach ($array as $referrer => $userArray) {
                $api->getUserAllData(array_unique($userArray), $referrer);
            }
        }
    }

    public function getDb($apiData)
    {
        $idvisits = [];
        $data = [];
        foreach ($apiData as $k => $v) {
            $data[$v['idVisit']] = $v;
            $idvisits[] = $v['idVisit'];
        }
        $idvisits = array_unique($idvisits);
        $find = ApiVisitorDetail::find()->where([
            "in", "idvisit", $idvisits
        ])->asArray()->all();
        //格式化username
        $find = ArrayHelper::index($find, 'idvisit');
        foreach ($data as $k => $v) {
            $array = isset($find[$k]) ? $find[$k] : false;

            $data[$k]['ip'] = $array ? $array['ip'] : '';
            $data[$k]['iptype'] = $array ? $array['iptype'] : '';
            $data[$k]['iptext'] = $array ? $array['iptext'] : '';

            for ($i = 0 ; $i < 10 ; $i++) {
                $data[$k]['visitor_datatype_' . $i] = ($array ? $array['visitor_datatype_' . $i] : '');
            }
        }
        return $data;
    }

}
