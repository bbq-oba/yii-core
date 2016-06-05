<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StatVisit;

/**
 * StatVisitSearch represents the model behind the search form about `app\models\StatVisit`.
 */
class StatVisitSearch extends StatVisit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'updated_datatype_0', 'updated_datatype_1', 'updated_datatype_2', 'updated_datatype_3', 'updated_datatype_4', 'updated_datatype_5', 'updated_datatype_6', 'updated_datatype_7', 'updated_datatype_8', 'updated_datatype_9', 'visitor_referrer', 'iptype', 'updated_at', 'created_at', 'visitor_regtime', 'month_cron'], 'integer'],
            [['idvisitor', 'location_ip', 'visitor_username', 'visitor_datatype_0', 'visitor_datatype_1', 'visitor_datatype_2', 'visitor_datatype_3', 'visitor_datatype_4', 'visitor_datatype_5', 'visitor_datatype_6', 'visitor_datatype_7', 'visitor_datatype_8', 'visitor_datatype_9', 'iptext'], 'safe'],
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
        $query = StatVisit::find();

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
            'id' => $this->id,
            'status' => $this->status,
            'updated_datatype_0' => $this->updated_datatype_0,
            'updated_datatype_1' => $this->updated_datatype_1,
            'updated_datatype_2' => $this->updated_datatype_2,
            'updated_datatype_3' => $this->updated_datatype_3,
            'updated_datatype_4' => $this->updated_datatype_4,
            'updated_datatype_5' => $this->updated_datatype_5,
            'updated_datatype_6' => $this->updated_datatype_6,
            'updated_datatype_7' => $this->updated_datatype_7,
            'updated_datatype_8' => $this->updated_datatype_8,
            'updated_datatype_9' => $this->updated_datatype_9,
            'visitor_referrer' => $this->visitor_referrer,
            'iptype' => $this->iptype,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'visitor_regtime' => $this->visitor_regtime,
            'month_cron' => $this->month_cron,
        ]);

        $query->andFilterWhere(['like', 'idvisitor', $this->idvisitor])
            ->andFilterWhere(['like', 'location_ip', $this->location_ip])
            ->andFilterWhere(['like', 'visitor_username', $this->visitor_username])
            ->andFilterWhere(['like', 'visitor_datatype_0', $this->visitor_datatype_0])
            ->andFilterWhere(['like', 'visitor_datatype_1', $this->visitor_datatype_1])
            ->andFilterWhere(['like', 'visitor_datatype_2', $this->visitor_datatype_2])
            ->andFilterWhere(['like', 'visitor_datatype_3', $this->visitor_datatype_3])
            ->andFilterWhere(['like', 'visitor_datatype_4', $this->visitor_datatype_4])
            ->andFilterWhere(['like', 'visitor_datatype_5', $this->visitor_datatype_5])
            ->andFilterWhere(['like', 'visitor_datatype_6', $this->visitor_datatype_6])
            ->andFilterWhere(['like', 'visitor_datatype_7', $this->visitor_datatype_7])
            ->andFilterWhere(['like', 'visitor_datatype_8', $this->visitor_datatype_8])
            ->andFilterWhere(['like', 'visitor_datatype_9', $this->visitor_datatype_9])
            ->andFilterWhere(['like', 'iptext', $this->iptext]);

        return $dataProvider;
    }
}
