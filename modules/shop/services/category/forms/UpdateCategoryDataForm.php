<?php

namespace app\modules\shop\services\category\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\CategoryData;
use yii\base\Model;

class UpdateCategoryDataForm extends Model
{
    public $id;
    public $category_id;
    public $language_code;
    public $name;
    public $description;
    public $slug;

    public function __construct(CategoryData $model, $languageCode, array $config = [])
    {
        parent::__construct($config);
        $this->id = $model->id;
        $this->category_id = $model->category_id;
        $this->language_code = $languageCode;
        $this->name = $model->name;
        $this->description = $model->description;
        $this->slug = $model->slug;
    }

    public function rules()
    {
        return [
            [['name', 'description', 'slug'], HtmlPurifierFilter::class],
            [['name', 'description', 'slug'], 'trim'],
            [['name', 'description', 'slug'], 'default'],

            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],

            [['description'], 'string'],

            [['slug'], 'match', 'pattern' => '/^[a-z0-9-]+$/'],

            [['name'], 'unique', 'targetClass' => CategoryData::class, 'targetAttribute' => 'name', 'filter' => ['AND', ['language_code' => $this->language_code], ['NOT', ['id' => $this->id]]]],
            [['slug'], 'unique', 'targetClass' => CategoryData::class, 'targetAttribute' => 'slug', 'filter' => ['AND', ['language_code' => $this->language_code], ['NOT', ['id' => $this->id]]]],
        ];
    }
}
