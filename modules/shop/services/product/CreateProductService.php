<?php

namespace app\modules\shop\services\product;

use app\models\Language;
use app\modules\shop\components\Service;
use app\modules\shop\domains\product\Product;
use app\modules\shop\services\category\CreateOrUpdateCategoryDataService;
use app\modules\shop\services\category\forms\CreateCategoryDataForm;
use app\modules\shop\services\product\forms\CreateProductDataForm;
use yii\base\Exception;
use yii\helpers\Json;

class CreateProductService extends Service
{
    public function execute()
    {
        $model = new Product();

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

    private function createDefaultTranslations(Product $model, $languageCode)
    {
        $form = new CreateProductDataForm($model, $languageCode, [
            'description' => $model->name . ' description',
        ]);

        if ($form->validate()) {
            $service = new CreateOrUpdateProductDataService($form);
            if ($service->execute()) {
                return;
            }
        }

        throw new Exception(Json::errorSummary($form));
    }
}
