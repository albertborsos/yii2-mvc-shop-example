<?php

namespace app\modules\shop\services\product;

use app\modules\shop\components\Service;

class UpdateProductService extends Service
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
