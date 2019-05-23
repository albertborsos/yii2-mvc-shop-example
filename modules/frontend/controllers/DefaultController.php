<?php

namespace app\modules\frontend\controllers;

use app\modules\frontend\services\AuthUserService;
use app\modules\frontend\services\login\forms\LoginForm;
use app\modules\shop\domains\category\CategoryData;
use app\modules\shop\domains\product\Product;
use app\modules\shop\domains\product\ProductData;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthUserService($client))->execute();
    }

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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('login');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
