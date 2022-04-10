<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserBook;

/**
 * SearchUserBook represents the model behind the search form of `app\models\UserBook`.
 */
class SearchUserBook extends UserBook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'read_status','rate'], 'integer'],
            [['book_id', 'created_at', 'updated_at'], 'safe'],
            [
                ['read_at'], 'date', 'format' => Yii::$app->formatter->dateFormat,   // 'php:Y-m-d H:i:s'
                'message' => 'Format de date invalide : '. Yii::$app->formatter->dateFormat
            ],             
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = UserBook::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'read_status' => $this->read_status,
            'read_at' => $this->read_at,
            'rate' => $this->rate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'book_id', $this->book_id]);

        return $dataProvider;
    }
}
