<?php

namespace app\modules\shop\services\category;

use app\models\Language;
use app\modules\shop\components\Service;
use app\modules\shop\domains\category\Category;
use app\modules\shop\services\category\forms\CreateCategoryDataForm;
use app\modules\shop\services\category\forms\CreateCategoryForm;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class CreateCategoryService
 * @package app\modules\shop\services\category
 * @property CreateCategoryForm $form
 */
class CreateCategoryService extends Service
{
    public function execute()
    {
        $model = new Category();

        $model->setAttributes($this->form->attributes);

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if ($model->save()) {
                foreach (array_keys(Language::allowed()) as $languageCode) {
                    $this->createDefaultTranslations($model, $languageCode);
                }
                $transaction->commit();
                return $model->id;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }

    private function createDefaultTranslations(Category $model, $languageCode)
    {
        $form = new CreateCategoryDataForm($model, $languageCode, [
            'description' => $model->name . ' description',
        ]);

        if ($form->validate()) {
            $service = new CreateOrUpdateCategoryDataService($form);
            if ($service->execute()) {
                return;
            }
        }

        throw new Exception(Json::errorSummary($form));
    }
}
