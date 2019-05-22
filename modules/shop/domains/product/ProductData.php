<?php

namespace app\modules\shop\domains\product;

use app\models\Language;
use app\modules\shop\services\product\forms\CreateProductDataForm;
use app\modules\shop\services\product\forms\UpdateProductDataForm;
use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\View;

class ProductData extends AbstractProductData
{
    const MAP_FORMS = [
        'create' => CreateProductDataForm::class,
        'update' => UpdateProductDataForm::class,
    ];

    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'blameable' => BlameableBehavior::class,
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'ensureUnique' => true,
                'uniqueValidator' => [
                    'filter' => $this->isNewRecord
                        ? ['language_code' => $this->language_code]
                        : ['AND', ['language_code' => $this->language_code], ['NOT', ['id' => $this->id]]],
                ],
            ],
        ];
    }

    public static function updateTabItems(View $view, Model $form)
    {
        $items = [];

        foreach (Language::allowed() as $languageCode => $languageName) {
            if ($languageCode === $form->language_code) {
                $items[] = [
                    'label' => $languageName,
                    'content' => $view->render('@app/modules/shop/views/product-data/_form', [
                        'model' => $form,
                    ]),
                ];
                continue;
            }

            $items[] = [
                'label' => $languageName,
                'url' => ['/shop/product/update', 'id' => $form->product_id, 'languageCode' => $languageCode],
                'content' => '',
                'active' => $form->language_code === $languageCode,
            ];
        }

        return $items;
    }

    public static function getForm(Product $model, $languageCode)
    {
        $productData = ProductData::findOne([
            'product_id' => $model->id,
            'language_code' => $languageCode,
        ]);
        $scenario = !empty($productData) ? 'update' : 'create';

        return \Yii::createObject(self::MAP_FORMS[$scenario], [!empty($productData) ? $productData : $model, $languageCode]);
    }

    public function getUrl()
    {
        return Url::to(['/shop/' . $this->slug]);
    }
}
