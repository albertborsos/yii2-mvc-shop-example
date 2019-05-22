<?php

namespace app\modules\shop\controllers;

use app\modules\shop\domains\category\CategoryData;
use app\modules\shop\domains\product\ProductData;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex($slug)
    {
        $category = CategoryData::findOne(['slug' => $slug, 'language_code' => \Yii::$app->language]);

        if ($category) {
            return $this->actionCategory($category);
        }

        $product = ProductData::findOne(['slug' => $slug, 'language_code' => \Yii::$app->language]);

        if ($product) {
            return $this->actionProduct($product);
        }

        throw new NotFoundHttpException('No item found!');
    }

    private function actionCategory(CategoryData $model)
    {
        return $this->render('category', [
            'category' => $model,
            'products' => $model->category->products,
            'languageCode' => \Yii::$app->language,
        ]);
    }

    private function actionProduct(ProductData $model)
    {
        return $this->render('product', [
            'product' => $model,
            'languageCode' => \Yii::$app->language,
        ]);
    }
}
