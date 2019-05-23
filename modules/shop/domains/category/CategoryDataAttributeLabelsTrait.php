<?php

namespace app\modules\shop\domains\category;

use Yii;

trait CategoryDataAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop/category-data', 'ID'),
            'category_id' => Yii::t('shop/category-data', 'Category ID'),
            'language_code' => Yii::t('shop/category-data', 'Language Code'),
            'name' => Yii::t('shop/category-data', 'Name'),
            'description' => Yii::t('shop/category-data', 'Description'),
            'slug' => Yii::t('shop/category-data', 'Slug'),
            'created_at' => Yii::t('shop/category-data', 'Created At'),
            'created_by' => Yii::t('shop/category-data', 'Created By'),
            'updated_at' => Yii::t('shop/category-data', 'Updated At'),
            'updated_by' => Yii::t('shop/category-data', 'Updated By'),
        ];
    }
}