<?php

namespace app\modules\shop\controllers;

use app\models\Language;
use app\modules\shop\domains\category\CategoryData;
use app\modules\shop\services\category\CreateCategoryService;
use app\modules\shop\services\category\forms\CreateCategoryForm;
use app\modules\shop\services\category\forms\UpdateCategoryForm;
use app\modules\shop\services\category\CreateOrUpdateCategoryDataService;
use app\modules\shop\services\category\UpdateCategoryService;
use Yii;
use app\modules\shop\domains\category\Category;
use app\modules\shop\domains\category\CategorySearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new CreateCategoryForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $service = new CreateCategoryService($form);
            if ($id = $service->execute()) {
                return $this->redirect(['update', 'id' => $id]);
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id, $languageCode = null)
    {
        $languageCodes = array_keys(Language::allowed());
        $languageCode = $languageCode ?? array_shift($languageCodes);

        $model = $this->findModel($id);
        $form = new UpdateCategoryForm($model);

        $dataForm = CategoryData::getForm($model, $languageCode);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $service = new UpdateCategoryService($form, $model);
            if ($id = $service->execute()) {
                return $this->redirect(['update', 'id' => $id]);
            }
        }

        if ($dataForm->load(Yii::$app->request->post()) && $dataForm->validate()) {
            $service = new CreateOrUpdateCategoryDataService($dataForm, $model->getCategoryDatas()->andWhere(['language_code' => $languageCode])->one());
            if ($dataId = $service->execute()) {
                return $this->redirect(['update', 'id' => $id, 'languageCode' => $dataForm->language_code]);
            }
        }

        return $this->render('update', [
            'model' => $form,
            'form' =>$dataForm,
        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('shop/category', 'The requested page does not exist.'));
    }
}
