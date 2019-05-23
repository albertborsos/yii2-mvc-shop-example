<?php
/** @var \app\modules\shop\domains\product\ProductData $productData */
?>
<div class="col-item">
    <div class="photo">
        <img src="http://placehold.it/350x260" class="img-responsive" alt="a">
    </div>
    <div class="info">
        <div class="row">
            <div class="price col-md-6">
                <h5><?= $productData->name ?></h5>
            </div>
            <div class="rating hidden-sm col-md-6">
                <h5 class="price-text-color"><?= $productData->product->price ?></h5>
            </div>
            <div class="col-md-12">
                <p><?= $productData->getDescriptionChunk() ?></p>
            </div>
        </div>
        <div class="separator clear-left">
            <p class="text-center btn-block">
                <i class="fa fa-list"></i><a href="<?= $productData->getUrl() ?>" class="hidden-sm">More details</a></p>
        </div>
        <div class="clearfix">
        </div>
    </div>
</div>
