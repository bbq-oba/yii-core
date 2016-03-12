<?php

namespace app\modules\sms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sms\models\SendingSms;

/**
 * SendingSmsSearch represents the model behind the search form about `app\modules\sms\models\SendingSms`.
 */
class SendingSmsSearch extends SendingSms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SmsIndex', 'UserDefineNo', 'SendLevel', 'SendModem', 'NewFlag'], 'integer'],
            [['SmsUser', 'PhoneNumber', 'SmsContent', 'PutInType', 'RM1', 'RM2', 'RM3'], 'safe'],
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
        $query = SendingSms::find();

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

        $query->andFilterWhere([
            'SmsIndex' => $this->SmsIndex,
            'UserDefineNo' => $this->UserDefineNo,
            'SendLevel' => $this->SendLevel,
            'SendModem' => $this->SendModem,
            'NewFlag' => $this->NewFlag,
        ]);

        $query->andFilterWhere(['like', 'SmsUser', $this->SmsUser])
            ->andFilterWhere(['like', 'PhoneNumber', $this->PhoneNumber])
            ->andFilterWhere(['like', 'SmsContent', $this->SmsContent])
            ->andFilterWhere(['like', 'PutInType', $this->PutInType])
            ->andFilterWhere(['like', 'RM1', $this->RM1])
            ->andFilterWhere(['like', 'RM2', $this->RM2])
            ->andFilterWhere(['like', 'RM3', $this->RM3]);

        return $dataProvider;
    }
}
