<?php

namespace app\modules\shop\domains\product;

use Yii;

trait ProductDataAttributeLabelsTrait
{
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
}