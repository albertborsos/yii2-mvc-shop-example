<?php

namespace app\modules\shop\services\category\forms;

use app\modules\shop\assets\SlugHandlerAsset;
use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\CategoryAttributeLabelsTrait;
use app\modules\shop\domains\category\Category;
use yii\base\Model;

class UpdateCategoryForm extends Model
{
    use CategoryAttributeLabelsTrait;

    public $id;
    public $name;

    /** @var Category */
    protected $model;

    public function __construct(Category $model, array $config = [])
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->model = $model;
    }

    public function rules()
    {
        return [
            [['name'], HtmlPurifierFilter::class],
            [['name'], 'trim'],
            [['name'], 'default'],

            [['name'], 'string'],
            [['name'], 'required'],

            [['name'], 'unique', 'targetClass' => Category::class, 'targetAttribute' => 'name', 'filter' => ['NOT', ['id' => $this->model->id]]],
        ];
    }
}
