<?php

namespace app\modules\shop\services\product;

use app\models\Language;
use app\modules\shop\components\Service;
use app\modules\shop\domains\product\Product;
use app\modules\shop\services\product\forms\CreateProductDataForm;
use app\modules\shop\services\product\forms\CreateProductForm;
use app\modules\shop\traits\SingleImageUploadServiceTrait;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * Class CreateProductService
 * @package app\modules\shop\services\product
 * @property CreateProductForm $form
 */
class CreateProductService extends Service
{
    use SingleImageUploadServiceTrait;

    const SAVE_PATH = '@app/web/uploads/';

    public function execute()
    {
        $model = new Product();

        $model->setAttributes($this->form->attributes);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($model->save()) {
                $this->storeImage($model);
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
