<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApiUser;

/**
 * ApiUserSearch represents the model behind the search form about `app\models\ApiUser`.
 */
class ApiUserSearch extends ApiUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['UserName', 'Password', 'TrueName', 'Phone', 'ReferralCode', 'Email', 'ip'], 'safe'],
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
        $query = ApiUser::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Password', $this->Password])
            ->andFilterWhere(['like', 'TrueName', $this->TrueName])
            ->andFilterWhere(['like', 'Phone', $this->Phone])
            ->andFilterWhere(['like', 'ReferralCode', $this->ReferralCode])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
