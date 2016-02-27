<?php

namespace app\modules\sms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sms\models\SentSms;

/**
 * SentSmsSearch represents the model behind the search form about `app\modules\sms\models\SentSms`.
 */
class SentSmsSearch extends SentSms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SmsIndex', 'Status', 'NewFlag', 'UserDefineNo', 'SentSetIndex'], 'integer'],
            [['PhoneNumber', 'SmsContent', 'SmsTime', 'SmsUser', 'RM1', 'RM2', 'RM3', 'RecvReportTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SentSms::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->orderBy("SmsTime DESC");
        $query->andFilterWhere([
            'SmsIndex' => $this->SmsIndex,
//            'SmsTime' => $this->SmsTime,
            'Status' => $this->Status,
            'NewFlag' => $this->NewFlag,
            'UserDefineNo' => $this->UserDefineNo,
            'SentSetIndex' => $this->SentSetIndex,
        ]);

        if(!empty($this->SmsTime) && strpos($this->SmsTime," 至 ")){
            list($startTime,$endTime) = explode(" 至 ",$this->SmsTime);
            $query->andFilterWhere(["between","SmsTime",$startTime,$endTime]);
        }


        $query->andFilterWhere(['like', 'PhoneNumber', $this->PhoneNumber])
            ->andFilterWhere(['like', 'SmsContent', $this->SmsContent])
            ->andFilterWhere(['like', 'SmsUser', $this->SmsUser])
            ->andFilterWhere(['like', 'RM1', $this->RM1])
            ->andFilterWhere(['like', 'RM2', $this->RM2])
            ->andFilterWhere(['like', 'RM3', $this->RM3])
            ->andFilterWhere(['like', 'RecvReportTime', $this->RecvReportTime]);

        return $dataProvider;
    }
}
