<?php

namespace app\modules\shop\domains\product;

use Yii;

trait ProductAttributeLabelsTrait
{

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop/product', 'ID'),
            'category_id' => Yii::t('shop/product', 'Category'),
            'name' => Yii::t('shop/product', 'Name'),
            'price' => Yii::t('shop/product', 'Price'),
            'created_at' => Yii::t('shop/product', 'Created At'),
            'created_by' => Yii::t('shop/product', 'Created By'),
            'updated_at' => Yii::t('shop/product', 'Updated At'),
            'updated_by' => Yii::t('shop/product', 'Updated By'),
        ];
    }
}