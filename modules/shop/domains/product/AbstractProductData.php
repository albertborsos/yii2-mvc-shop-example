<?php

namespace app\modules\shop\domains\product;

use Yii;

/**
 * This is the model class for table "shop_product_data".
 *
 * @property int $id
 * @property int $product_id
 * @property string $language_code
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Product $product
 */
abstract class AbstractProductData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_product_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'language_code', 'name', 'slug', 'description'], 'required'],
            [['product_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['language_code'], 'string', 'max' => 2],
            [['name', 'slug'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop/product-data', 'ID'),
            'product_id' => Yii::t('shop/product-data', 'Product ID'),
            'language_code' => Yii::t('shop/product-data', 'Language Code'),
            'name' => Yii::t('shop/product-data', 'Name'),
            'slug' => Yii::t('shop/product-data', 'Slug'),
            'description' => Yii::t('shop/product-data', 'Description'),
            'created_at' => Yii::t('shop/product-data', 'Created At'),
            'created_by' => Yii::t('shop/product-data', 'Created By'),
            'updated_at' => Yii::t('shop/product-data', 'Updated At'),
            'updated_by' => Yii::t('shop/product-data', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductDataQuery(get_called_class());
    }
}
