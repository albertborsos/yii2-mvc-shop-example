<?php

namespace app\modules\shop\domains\product;

use Yii;

/**
 * This is the model class for table "shop_product_image".
 *
 * @property int $id
 * @property int $product_id
 * @property string $filename
 * @property string $title
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Product $product
 */
abstract class AbstractProductImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_product_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'filename'], 'required'],
            [['product_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['filename', 'title'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop/product-image', 'ID'),
            'product_id' => Yii::t('shop/product-image', 'Product ID'),
            'filename' => Yii::t('shop/product-image', 'Filename'),
            'title' => Yii::t('shop/product-image', 'Title'),
            'created_at' => Yii::t('shop/product-image', 'Created At'),
            'created_by' => Yii::t('shop/product-image', 'Created By'),
            'updated_at' => Yii::t('shop/product-image', 'Updated At'),
            'updated_by' => Yii::t('shop/product-image', 'Updated By'),
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
     * @return ProductImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductImageQuery(get_called_class());
    }
}
