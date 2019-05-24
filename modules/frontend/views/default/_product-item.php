<?php
/** @var \app\modules\shop\domains\product\ProductData $productData */
/** @var \yii\i18n\Formatter $formatter */
?>
<div class="col-item">
    <div class="photo">
        <img src="<?= $productData->product->getImageUrl() ?>" class="img-responsive" alt="a">
    </div>
    <div class="info">
        <div class="row">
            <div class="price col-md-6">
                <h5><?= $productData->name ?></h5>
            </div>
            <div class="rating hidden-sm col-md-6">
                <h5 class="price-text-color"><?= $formatter->asCurrency($productData->product->price) ?></h5>
            </div>
            <div class="col-md-12">
                <p><?= $productData->getDescriptionChunk() ?></p>
            </div>
        </div>
        <div class="separator clear-left">
            <p class="text-center btn-block">
                <a href="<?= $productData->getUrl() ?>" class="hidden-sm btn btn-primary">More details</a></p>
        </div>
        <div class="clearfix">
        </div>
    </div>
</div>
