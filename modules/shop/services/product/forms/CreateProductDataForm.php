<?php

namespace app\modules\shop\services\product\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\product\Product;
use app\modules\shop\domains\product\ProductData;
use yii\base\Model;

class CreateProductDataForm extends Model
{
    public $product_id;
    public $language_code;
    public $name;
    public $description;

    public function __construct(Product $model, $languageCode, array $config = [])
    {
        parent::__construct($config);
        $this->product_id = $model->id;
        $this->language_code = $languageCode;
        $this->name = $model->name;
    }

    public function rules()
    {
        return [
            [['name', 'description'], HtmlPurifierFilter::class],
            [['name', 'description'], 'trim'],
            [['name', 'description'], 'default'],
            [['name', 'description'], 'string'],
            [['name', 'description'], 'required'],

            [['name'], 'unique', 'targetClass' => ProductData::class, 'targetAttribute' => 'name', 'filter' => ['language_code' => $this->language_code]],
        ];
    }
}
