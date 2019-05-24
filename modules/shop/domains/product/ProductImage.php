<?php

namespace app\modules\shop\domains\product;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

class ProductImage extends AbstractProductImage
{
    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'blameable' => BlameableBehavior::class,
        ];
    }

    public function getUrl()
    {
        return Url::to(['/uploads/' . $this->filename]);
    }

    public function deleteUrl()
    {
        return '#';
    }
}
