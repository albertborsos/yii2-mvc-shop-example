<?php

namespace app\modules\shop\domains\product;

use app\modules\shop\domains\category\Category;
use Yii;

/**
 * This is the model class for table "shop_product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property int $price
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Category $category
 * @property ProductData[] $shopProductDatas
 */
abstract class AbstractProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop/product', 'ID'),
            'category_id' => Yii::t('shop/product', 'Category ID'),
            'name' => Yii::t('shop/product', 'Name'),
            'price' => Yii::t('shop/product', 'Price'),
            'created_at' => Yii::t('shop/product', 'Created At'),
            'created_by' => Yii::t('shop/product', 'Created By'),
            'updated_at' => Yii::t('shop/product', 'Updated At'),
            'updated_by' => Yii::t('shop/product', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDatas()
    {
        return $this->hasMany(ProductData::className(), ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
