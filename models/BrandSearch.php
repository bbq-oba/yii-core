<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Brand;

/**
 * BrandSearch represents the model behind the search form about `app\models\Brand`.
 */
class BrandSearch extends Brand
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'show_type_name', 'is_show', 'is_deleted'], 'integer'],
            [['cn_name', 'en_name', 'py_name', 'initial', 'logo', 'sn', 'create_time', 'update_time'], 'safe'],
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
        $query = Brand::find();

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
            'show_type_name' => $this->show_type_name,
            'is_show' => $this->is_show,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'is_deleted' => 0,
        ]);

        $query->andFilterWhere(['like', 'cn_name', $this->cn_name])
            ->andFilterWhere(['like', 'en_name', $this->en_name])
            ->andFilterWhere(['like', 'py_name', $this->py_name])
            ->andFilterWhere(['like', 'initial', $this->initial])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'sn', $this->sn]);

        return $dataProvider;
    }
}
