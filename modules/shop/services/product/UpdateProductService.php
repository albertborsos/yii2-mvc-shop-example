<?php

namespace app\modules\shop\services\product;

use app\modules\shop\components\Service;
use app\modules\shop\traits\SingleImageUploadServiceTrait;

class UpdateProductService extends Service
{
    use SingleImageUploadServiceTrait;

    const SAVE_PATH = '@app/web/uploads/';

    public function execute()
    {
        $this->model->setAttributes($this->form->attributes);

        if ($this->model->save()) {
            $this->storeImage($this->model);
            return $this->model->id;
        }

        $this->form->addErrors($this->model->getErrors());

        return false;
    }
}
