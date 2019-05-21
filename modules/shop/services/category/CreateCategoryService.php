<?php

namespace app\modules\shop\services\category;

use app\modules\shop\components\Service;
use app\modules\shop\domains\category\Category;
use app\modules\shop\services\category\forms\CreateCategoryForm;

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

        if ($model->save()) {
            return $model->id;
        }

        $this->form->addErrors($model->getErrors());

        return false;
    }
}
