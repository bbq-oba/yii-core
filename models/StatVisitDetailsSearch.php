<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StatVisitDetails;

/**
 * StatVisitDetailsSearch represents the model behind the search form about `app\models\StatVisitDetails`.
 */
class StatVisitDetailsSearch extends StatVisitDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vid', 'referer_type', 'created_at', 'updated_at'], 'integer'],
            [['current_url', 'referer_name', 'referer_keyword', 'referer_url'], 'safe'],
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
        $query = StatVisitDetails::find();

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
            'vid' => $this->vid,
            'referer_type' => $this->referer_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->orderBy('updated_at desc');
        $query->andFilterWhere(['like', 'current_url', $this->current_url])
            ->andFilterWhere(['like', 'referer_name', $this->referer_name])
            ->andFilterWhere(['like', 'referer_keyword', $this->referer_keyword])
            ->andFilterWhere(['like', 'referer_url', $this->referer_url]);

        return $dataProvider;
    }
}
