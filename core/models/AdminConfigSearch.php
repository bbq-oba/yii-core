<?php
/**
 * @author oba.ou
 */
namespace app\core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\core\models\AdminConfig;

/**
 * AdminConfigSearch represents the model behind the search form about `app\core\models\AdminConfig`.
 */
class AdminConfigSearch extends AdminConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creater', 'is_deleted'], 'integer'],
            [['option_key', 'option_value', 'option_text', 'create_time', 'update_time'], 'safe'],
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
        $query = AdminConfig::find();

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
            'create_time' => $this->create_time,
            'creater' => $this->creater,
            'is_deleted' => 0,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'option_key', $this->option_key])
            ->andFilterWhere(['like', 'option_value', $this->option_value])
            ->andFilterWhere(['like', 'option_text', $this->option_text]);

        return $dataProvider;
    }
}
