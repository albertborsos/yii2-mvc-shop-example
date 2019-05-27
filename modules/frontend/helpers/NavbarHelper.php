<?php

namespace app\modules\frontend\helpers;

use app\modules\frontend\components\LanguageSelector;
use app\modules\shop\domains\category\Category;
use Yii;
use yii\helpers\Url;

class NavbarHelper
{
    public static function productsMenuItems()
    {
        $items = [];

        foreach (Category::find()->orderBy(['name' => SORT_ASC])->all() as $category) {
            if (!$category->getProducts()->exists()) {
                continue;
            }

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

    public static function languageSelector()
    {
        $items = [];

        foreach (LanguageSelector::allowed() as $languageCode => $languageName) {
            $items[] = [
                'label' => $languageName,
                'url' => Url::current(['language' => $languageCode]),
            ];
        }

        return [
            'label' => \yii\bootstrap\Html::icon('globe'),
            'items' => $items,
            'encode' => false,
        ];
    }
}