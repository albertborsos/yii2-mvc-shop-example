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
            $data = $category->data(Yii::$app->language, false);
            if (empty($data)) {
                continue;
            }
            $items[] = [
                'label' => $data->name,
                'url' => $data->getUrl(),
            ];
        }

        return [
            'label' => Yii::t('app', 'Products'),
            'items' => $items,
        ];
    }
}