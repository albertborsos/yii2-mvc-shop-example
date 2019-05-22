<?php

namespace app\modules\shop\services\category;

use app\modules\shop\components\Service;
use app\modules\shop\domains\category\CategoryData;
use app\modules\shop\services\category\forms\CreateCategoryForm;

/**
 * Class UpdateCategoryService
 * @package app\modules\shop\services\category
 * @property CreateCategoryForm $form
 * @property CategoryData $model
 */
class CreateOrUpdateCategoryDataService extends Service
{
    public function execute()
    {
        if (empty($this->model)) {
            $this->model = new CategoryData();
        }

        $this->model->setAttributes($this->form->attributes);

        if ($this->model->save()) {
            return $this->model->id;
        }

        $this->form->addErrors($this->model->getErrors());

        return false;
    }
}
