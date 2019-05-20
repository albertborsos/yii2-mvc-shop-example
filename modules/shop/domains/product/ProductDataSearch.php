<?php

namespace app\modules\shop\domains\product;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\domains\product\ProductData;

/**
 * ProductDataSearch represents the model behind the search form of `app\modules\shop\domains\product\ProductData`.
 */
class ProductDataSearch extends ProductData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['language_code', 'name', 'slug', 'description'], 'safe'],
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
        $query = ProductData::find();

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
            'product_id' => $this->product_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'language_code', $this->language_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
