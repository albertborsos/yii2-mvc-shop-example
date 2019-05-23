<?php

namespace app\modules\frontend\controllers;

use app\modules\shop\domains\category\CategoryData;
use app\modules\shop\domains\product\Product;
use app\modules\shop\domains\product\ProductData;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
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

    public function actionHome()
    {
        return $this->render('home', [
            'latestProducts' => Product::find()->orderBy(['id' => SORT_DESC])->limit(3)->all(),
            'languageCode' => \Yii::$app->language,
        ]);
    }

    private function actionCategory(CategoryData $model)
    {
        return $this->render('category', [
            'category' => $model,
            'languageCode' => \Yii::$app->language,
            'productsDataProvider' => new ActiveDataProvider([
                'query' => $model->category->getProducts(),
                'pagination' => [
                    'pageSize' => 6,
                ],
            ]),
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
