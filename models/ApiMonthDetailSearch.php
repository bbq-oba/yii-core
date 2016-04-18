<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApiMonthDetail;

/**
 * ApiMonthDetailSearch represents the model behind the search form about `app\models\ApiMonthDetail`.
 */
class ApiMonthDetailSearch extends ApiMonthDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idvisit', 'mtime', 'updated_datatype_13', 'updated_datatype_10', 'updated_datatype_11', 'updated_datatype_12', 'visitor_referrer', 'created_at', 'updated_at'], 'integer'],
            [['visitor_datatype_13', 'visitor_datatype_10', 'visitor_datatype_11', 'visitor_datatype_12', 'visitor_username'], 'safe'],
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
        $query = ApiMonthDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
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
            'idvisit' => $this->idvisit,
            'mtime' => $this->mtime,
            'updated_datatype_13' => $this->updated_datatype_13,
            'updated_datatype_10' => $this->updated_datatype_10,
            'updated_datatype_11' => $this->updated_datatype_11,
            'updated_datatype_12' => $this->updated_datatype_12,
            'visitor_referrer' => $this->visitor_referrer,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'visitor_datatype_13', $this->visitor_datatype_13])
            ->andFilterWhere(['like', 'visitor_datatype_10', $this->visitor_datatype_10])
            ->andFilterWhere(['like', 'visitor_datatype_11', $this->visitor_datatype_11])
            ->andFilterWhere(['like', 'visitor_datatype_12', $this->visitor_datatype_12])
            ->andFilterWhere(['like', 'visitor_username', $this->visitor_username]);

        return $dataProvider;
    }
}
