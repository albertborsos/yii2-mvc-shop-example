<?php

namespace app\modules\shop\services\product\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\product\ProductData;
use yii\base\Model;

class UpdateProductDataForm extends Model
{
    public $id;
    public $product_id;
    public $language_code;
    public $name;
    public $slug;
    public $description;

    public function __construct(ProductData $model, $languageCode, array $config = [])
    {
        parent::__construct($config);
        $this->id = $model->id;
        $this->product_id = $model->product_id;
        $this->language_code = $languageCode;
        $this->name = $model->name;
        $this->slug = $model->slug;
        $this->description = $model->description;
    }

    public function rules()
    {
        return [
            [['name', 'slug', 'description'], HtmlPurifierFilter::class],
            [['name', 'slug', 'description'], 'trim'],
            [['name', 'slug', 'description'], 'default'],
            [['name', 'slug', 'description'], 'string'],
            [['name', 'slug', 'description'], 'required'],

            [['name'], 'unique', 'targetClass' => ProductData::class, 'targetAttribute' => 'name', 'filter' => ['AND', ['language_code' => $this->language_code], ['NOT', ['id' => $this->id]]]],

            [['slug'], 'match', 'pattern' => '/^[a-z0-9-]+$/'],
            [['slug'], 'unique', 'targetClass' => ProductData::class, 'targetAttribute' => 'slug', 'filter' => ['AND', ['language_code' => $this->language_code], ['NOT', ['id' => $this->id]]]],
        ];
    }
}