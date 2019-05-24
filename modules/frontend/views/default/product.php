<?php
/* @var $this \yii\web\View */
/* @var $productData \app\modules\shop\domains\product\ProductData */
/* @var $languageCode string */
/* @var $formatter \yii\i18n\Formatter */
?>

<div class="row">
    <h1><?= $productData->name ?></h1>
    <div class="col-md-6">
        <img src="<?= $productData->product->getImageUrl() ?>" class="img-responsive" alt="a">
    </div>
    <div class="col-md-6">
        <h5 class="price-text-color"><?= $formatter->asCurrency($productData->product->price) ?></h5>
        <p><?= $productData->description ?></p>
    </div>
</div>


