<?php

namespace app\modules\frontend\controllers;

use app\modules\frontend\services\AuthUserService;
use app\modules\frontend\services\login\forms\LoginForm;
use app\modules\shop\domains\category\Category;
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
    public function actionIndex($slug = null)
    {
        if (empty($slug)) {
            return $this->actionHomeWebshop();
        }

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
        $this->view->title = Yii::$app->name;

        return $this->render('home', [
            'latestProducts' => Product::find()->orderBy(['id' => SORT_DESC])->limit(3)->all(),
            'formatter' => Yii::$app->formatter,
            'languageCode' => \Yii::$app->language,
        ]);
    }

    private function actionCategory(CategoryData $model)
    {
        $this->view->title = $model->name;

        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('shop/product', 'Products'), 'url' => ['/webshop']];
        $this->view->params['breadcrumbs'][] = $model->name;

        return $this->render('category', [
            'formatter' => Yii::$app->formatter,
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
        $this->view->title = $model->name;

        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('shop/product', 'Products'), 'url' => ['/webshop']];
        $this->view->params['breadcrumbs'][] = ['label' => $model->product->category->data($model->language_code)->name, 'url' => $model->product->category->data($model->language_code)->getUrl()];
        $this->view->params['breadcrumbs'][] = $model->name;

        return $this->render('product', [
            'formatter' => Yii::$app->formatter,
            'productData' => $model,
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

    private function actionHomeWebshop()
    {
        $this->view->title = Yii::t('shop/product', 'Products');

        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('shop/product', 'Products'), 'url' => ['/webshop']];

        return $this->render('home_webshop', [
            'categories' => Category::find()->orderBy(['name' => SORT_ASC])->all(),
            'languageCode' => Yii::$app->language,
        ]);
    }
}
