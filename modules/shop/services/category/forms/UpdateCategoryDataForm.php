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
    public $slug;

    public function __construct(CategoryData $model, $languageCode, array $config = [])
    {
        parent::__construct($config);
        $this->category_id = $model->category_id;
        $this->language_code = $languageCode;
        $this->name = $model->name;
        $this->slug = $model->slug;
    }

    public function rules()
    {
        return [
            [['name', 'slug'], HtmlPurifierFilter::class],
            [['name', 'slug'], 'trim'],
            [['name', 'slug'], 'default'],
            [['name', 'slug'], 'string'],
            [['name', 'slug'], 'required'],

            [['name'], 'unique', 'targetClass' => CategoryData::class, 'targetAttribute' => 'name'],
            [['slug'], 'unique', 'targetClass' => CategoryData::class, 'targetAttribute' => 'slug'],
        ];
    }
}
