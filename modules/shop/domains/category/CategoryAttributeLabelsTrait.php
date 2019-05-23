<?php

namespace app\modules\shop\domains\category;

use Yii;

trait CategoryAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop/category', 'ID'),
            'name' => Yii::t('shop/category', 'Name'),
            'created_at' => Yii::t('shop/category', 'Created At'),
            'created_by' => Yii::t('shop/category', 'Created By'),
            'updated_at' => Yii::t('shop/category', 'Updated At'),
            'updated_by' => Yii::t('shop/category', 'Updated By'),
        ];
    }
}