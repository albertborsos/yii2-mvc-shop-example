<?php

namespace app\modules\shop\services\category\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\Category;
use yii\base\Model;

class CreateCategoryForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], HtmlPurifierFilter::class],
            [['name'], 'trim'],
            [['name'], 'default'],

            [['name'], 'string'],
            [['name'], 'required'],
            [['name'], 'unique', 'targetClass' => Category::class, 'targetAttribute' => 'name'],
        ];
    }
}
