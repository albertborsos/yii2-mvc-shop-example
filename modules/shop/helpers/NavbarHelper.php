<?php

namespace app\modules\shop\helpers;

use app\modules\shop\domains\category\Category;
use Yii;
use yii\helpers\ArrayHelper;

class NavbarHelper
{
    public static function productsMenuItems()
    {
        $items = [];

        foreach (Category::find()->orderBy(['name' => SORT_ASC])->all() as $category) {
            $items[] = [
                'label' => $category->data(Yii::$app->language)->name,
                'url' => $category->data(Yii::$app->language)->getUrl(),
            ];
        }

        return [
            'label' => Yii::t('app', 'Products'),
            'items' => $items,
        ];
    }
}