<?php

namespace app\modules\shop\services\category\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\category\CategoryData;
use app\modules\shop\domains\category\CategoryDataAttributeLabelsTrait;
use yii\base\Model;

class CreateCategoryDataForm extends Model
{
    use CategoryDataAttributeLabelsTrait;

    public $category_id;
    public $language_code;
    public $name;
    public $description;

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
            [['name', 'description'], HtmlPurifierFilter::class],
            [['name', 'description'], 'trim'],
            [['name', 'description'], 'default'],

            [['name'], 'required'],

            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => CategoryData::class, 'targetAttribute' => 'name', 'filter' => ['language_code' => $this->language_code]],

            [['description'], 'string'],
        ];
    }
}
