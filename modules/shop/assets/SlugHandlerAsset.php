<?php

namespace app\modules\shop\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class SlugHandlerAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/shop/assets/slug-handler';

    public $js = [
        'js/handler.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
