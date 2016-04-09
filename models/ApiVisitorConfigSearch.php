<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApiVisitorConfig;

/**
 * ApiVisitorConfigSearch represents the model behind the search form about `app\models\ApiVisitorConfig`.
 */
class ApiVisitorConfigSearch extends ApiVisitorConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'limit', 'time', 'from', 'to', 'range'], 'integer'],
            [['name', 'where', 'order', 'url'], 'safe'],
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
        $query = ApiVisitorConfig::find();

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
            'type' => $this->type,
            'limit' => $this->limit,
            'time' => $this->time,
            'from' => $this->from,
            'to' => $this->to,
            'range' => $this->range,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'where', $this->where])
            ->andFilterWhere(['like', 'order', $this->order])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
