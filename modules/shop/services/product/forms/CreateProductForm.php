<?php

namespace app\modules\shop\services\product\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\product\ProductAttributeLabelsTrait;
use app\modules\shop\domains\product\Product;
use app\modules\shop\traits\SingleImageUploadFormTrait;
use yii\base\Model;
use yii\web\UploadedFile;

class CreateProductForm extends Model
{
    use ProductAttributeLabelsTrait;
    use SingleImageUploadFormTrait;

    public $category_id;
    public $name;
    public $price;

    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            $this->imageFile = $this->imageFile ?: UploadedFile::getInstance($this, 'imageFile');
            return true;
        }

        return false;
    }

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

            [['imageFile'], 'file', 'maxSize' => 3 * 1024 * 1024, 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],
        ];
    }
}
