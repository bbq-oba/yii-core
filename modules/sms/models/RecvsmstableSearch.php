<?php

namespace app\modules\sms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sms\models\Recvsmstable;

/**
 * RecvsmstableSearch represents the model behind the search form about `app\modules\sms\models\Recvsmstable`.
 */
class RecvsmstableSearch extends Recvsmstable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SmsIndex', 'NewFlag'], 'integer'],
            [['SmsTime', 'SendNumber', 'SmsContent', 'RecvModemSet', 'SendTime', 'SMSCID'], 'safe'],
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
        $query = Recvsmstable::find();

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
            'SmsTime' => $this->SmsTime,
            'NewFlag' => $this->NewFlag,
            'SendTime' => $this->SendTime,
        ]);

        $query->andFilterWhere(['like', 'SendNumber', $this->SendNumber])
            ->andFilterWhere(['like', 'SmsContent', $this->SmsContent])
            ->andFilterWhere(['like', 'RecvModemSet', $this->RecvModemSet])
            ->andFilterWhere(['like', 'SMSCID', $this->SMSCID]);

        return $dataProvider;
    }
}
