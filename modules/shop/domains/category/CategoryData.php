<?php

namespace app\modules\shop\domains\category;

use app\models\Language;
use app\modules\shop\services\category\forms\CreateCategoryDataForm;
use app\modules\shop\services\category\forms\UpdateCategoryDataForm;
use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\web\View;


class CategoryData extends AbstractCategoryData
{
    use CategoryDataAttributeLabelsTrait;

    const MAP_FORMS = [
        'create' => CreateCategoryDataForm::class,
        'update' => UpdateCategoryDataForm::class,
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

    /**
     * @param Category $model
     * @param $languageCode
     * @return CreateCategoryDataForm|UpdateCategoryDataForm
     * @throws \yii\base\InvalidConfigException
     */
    public static function getForm(Category $model, $languageCode)
    {
        $categoryData = CategoryData::findOne([
            'category_id' => $model->id,
            'language_code' => $languageCode,
        ]);
        $scenario = !empty($categoryData) ? 'update' : 'create';

        return \Yii::createObject(self::MAP_FORMS[$scenario], [!empty($categoryData) ? $categoryData : $model, $languageCode]);
    }

    public static function updateTabItems(View $view, Model $form)
    {
        $items = [];

        foreach (Language::allowed() as $languageCode => $languageName) {
            if ($languageCode === $form->language_code) {
                $items[] = [
                    'label' => $languageName,
                    'content' => $view->render('@app/modules/shop/views/category-data/_form', [
                        'model' => $form,
                    ]),
                ];
                continue;
            }

            $items[] = [
                'label' => $languageName,
                'url' => ['/shop/category/update', 'id' => $form->category_id, 'languageCode' => $languageCode],
                'content' => '',
                'active' => $form->language_code === $languageCode,
            ];
        }

        return $items;
    }

    public function getUrl()
    {
        return ['/shop/' . $this->slug];
    }
}
