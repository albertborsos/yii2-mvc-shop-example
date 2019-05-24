<?php

namespace app\modules\shop\traits;

use app\modules\shop\domains\product\Product;
use app\modules\shop\domains\product\ProductImage;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

trait SingleImageUploadFormTrait
{
    public $imageFile;
    public $image_id;

    protected $businessModelClass = Product::class;
    protected $resourceClass = Product::class;

    public function getFileUploadPluginOptions()
    {
        $defaultConfig = [
            'layoutTemplates' => [
                'modal' => '<div class="modal-dialog modal-lg{rtl}" role="document">' .
                    '  <div class="modal-content">' .
                    '    <div class="modal-header">' .
                    '      <div class="kv-zoom-actions pull-right">{close}</div>' .
                    '      <h3 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h3>' .
                    '    </div>' .
                    '    <div class="modal-body" style="overflow-y:auto;">' .
                    '      <div class="floating-buttons"></div>' .
                    '      <div class="kv-zoom-body file-zoom-content"></div>' .
                    '    </div>' .
                    '  </div>' .
                    '</div>',
            ],
            'overwriteInitial' => true,
            'showClose' => false,
            'showRemove' => false,
            'showUpload' => false,
            'indicatorNew' => false,
            'fileActionSettings' => [
                'showUpload' => false,
                'showDrag' => false,
            ],
        ];

        if ($this->image_id === null) {
            return $defaultConfig;
        }

        $image = ProductImage::find()->where(['product_id' => $this->product->id])->orderBy(['id' => SORT_DESC])->one();

        if ($image === null) {
            return $defaultConfig;
        }

        return array_merge($defaultConfig, [
            'initialPreview' => $this->getFileUploadInitialPreview($image),
            'initialPreviewConfig' => $this->getFileUploadInitialPreviewConfig($image),
        ]);
    }

    protected function getFileUploadInitialPreview(ProductImage $image = null)
    {
        if ($image === null) {
            return [];
        }

        return [
            Html::img($image->getUrl(), ['class' => 'file-preview-image img-responsive']),
        ];
    }

    protected function getFileUploadInitialPreviewConfig(ProductImage $image = null)
    {
        if ($image === null) {
            return [];
        }

        if (empty($this->businessModelClass)) {
            throw new InvalidConfigException(get_called_class() . '::$businessModelClass must be set in `init()` method.');
        }

        if (empty($this->resourceClass)) {
            throw new InvalidConfigException(get_called_class() . '::$resourceClass must be set in `init()` method.');
        }

        return [
            [
                'url' => $image->deleteUrl(),
                'key' => $image->id,
                'extra' => [
                    'removeImageFrom' => [
                        'resourceClass'      => $this->resourceClass,
                        'businessModelClass' => $this->businessModelClass,
                        'businessModelId'    => $this->id,
                    ],
                ],
            ],
        ];
    }
}
