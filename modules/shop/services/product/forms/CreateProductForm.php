<?php

namespace app\modules\shop\services\product\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\product\Product;
use yii\base\Model;

class CreateProductForm extends Model
{
    public $category_id;
    public $name;
    public $price;

    public function rules()
    {
        return [
            [['category_id', 'name', 'price'], HtmlPurifierFilter::class],
            [['category_id', 'name', 'price'], 'trim'],
            [['category_id', 'name', 'price'], 'default'],
            [['category_id', 'name', 'price'], 'required'],

            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],

            [['name'], 'unique', 'targetClass' => Product::class, 'targetAttribute' => 'name'],

            [['price'], 'number', 'min' => 0],
        ];
    }
}
