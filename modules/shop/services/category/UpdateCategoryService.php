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
class UpdateCategoryService extends Service
{
    public function execute()
    {
        $this->model->setAttributes($this->form->attributes);

        if ($this->model->save()) {
            return $this->model->id;
        }

        $this->form->addErrors($this->model->getErrors());

        return false;
    }
}
