<?php

namespace app\modules\shop\controllers;

use app\models\Language;
use app\modules\shop\domains\product\ProductData;
use app\modules\shop\services\product\CreateOrUpdateProductDataService;
use app\modules\shop\services\product\CreateProductService;
use app\modules\shop\services\product\forms\CreateProductForm;
use app\modules\shop\services\product\forms\UpdateProductForm;
use app\modules\shop\services\product\UpdateProductService;
use Yii;
use app\modules\shop\domains\product\Product;
use app\modules\shop\domains\product\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateProductForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $service = new CreateProductService($model);
            if ($id = $service->execute()) {
                return $this->redirect(['update', 'id' => $id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $languageCode = null)
    {
        $languageCodes = array_keys(Language::allowed());
        $languageCode = $languageCode ?? array_shift($languageCodes);

        $model = $this->findModel($id);
        $form = new UpdateProductForm($model);

        $dataForm = ProductData::getForm($model, $languageCode);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $service = new UpdateProductService($form, $model);
            if ($service->execute()) {
                return $this->redirect(['update', 'id' => $form->id]);
            }
        }

        if ($dataForm->load(Yii::$app->request->post()) && $dataForm->validate()) {
            $service = new CreateOrUpdateProductDataService($dataForm, $model->data($languageCode, false));
            if ($dataId = $service->execute()) {
                return $this->redirect(['update', 'id' => $id, 'languageCode' => $dataForm->language_code]);
            }
        }

        return $this->render('update', [
            'model' => $form,
            'form' => $dataForm,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('shop/product', 'The requested page does not exist.'));
    }
}
