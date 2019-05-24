<?php

namespace app\modules\shop\domains\product;

use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\category\CategoryData;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form of `app\modules\shop\domains\product\Product`.
 */
class ProductSearch extends Product
{
    use ProductAttributeLabelsTrait;

    public $category;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'category'], 'safe'],
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
        $query = Product::find();

        $query->joinWith(['category', 'category.categoryDatas']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['category'] = [
            'asc' => [Category::tableName() . '.name' => SORT_ASC],
            'desc' => [Category::tableName() . '.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere([
            'OR',
            ['like', Category::tableName() . '.name', $this->category],
            ['like', CategoryData::tableName() . '.name', $this->category],
        ]);

        return $dataProvider;
    }
}
