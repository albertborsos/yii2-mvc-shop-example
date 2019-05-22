<?php

namespace app\modules\shop\services\product;

use app\modules\shop\components\Service;
use app\modules\shop\domains\product\ProductData;

class CreateOrUpdateProductDataService extends Service
{
    public function execute()
    {
        if (empty($this->model)) {
            $this->model = new ProductData();
        }

        $this->model->setAttributes($this->form->attributes);

        if ($this->model->save()) {
            return $this->model->id;
        }

        $this->form->addErrors($this->model->getErrors());

        return false;
    }
}