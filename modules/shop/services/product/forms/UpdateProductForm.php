<?php

namespace app\modules\shop\services\product\forms;

use app\modules\shop\components\validators\HtmlPurifierFilter;
use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\product\ProductAttributeLabelsTrait;
use app\modules\shop\domains\product\Product;
use app\modules\shop\traits\SingleImageUploadFormTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class UpdateProductForm extends Model
{
    use ProductAttributeLabelsTrait;
    use SingleImageUploadFormTrait;

    public $id;
    public $category_id;
    public $name;
    public $price;

    /** @var Product  */
    private $product;

    public function __construct(Product $model, array $config = [])
    {
        parent::__construct($config);
        $this->id = $model->id;
        $this->category_id = $model->category_id;
        $this->name = $model->name;
        $this->price = $model->price;

        $this->product = $model;
        $this->image_id = ArrayHelper::getValue($model->productImages, '0.id');
    }

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

            [['name'], 'unique', 'targetClass' => Product::class, 'targetAttribute' => 'name', 'filter' => ['NOT', ['id' => $this->id]]],

            [['price'], 'number', 'min' => 0],

            [['imageFile'], 'file', 'maxSize' => 3 * 1024 * 1024, 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],
        ];
    }

}