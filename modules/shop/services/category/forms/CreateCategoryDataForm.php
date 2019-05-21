<?php

namespace app\modules\shop\services\category\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\category\CategoryData;
use yii\base\Model;

class CreateCategoryDataForm extends Model
{
    public $category_id;
    public $language_code;
    public $name;

    public function __construct(Category $model, $languageCode, array $config = [])
    {
        parent::__construct($config);
        $this->category_id = $model->id;
        $this->language_code = $languageCode;
        $this->name = $model->name;
    }

    public function rules()
    {
        return [
            [['name'], HtmlPurifierFilter::class],
            [['name'], 'trim'],
            [['name'], 'default'],
            [['name'], 'string'],
            [['name'], 'required'],

            [['name'], 'unique', 'targetClass' => CategoryData::class, 'targetAttribute' => 'name'],
        ];
    }
}
