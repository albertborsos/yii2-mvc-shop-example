<?php
/* @var $this \yii\web\View */
/* @var $product \app\modules\shop\domains\product\ProductData */
/* @var $languageCode string */
/* @var $formatter \yii\i18n\Formatter */
?>

<div class="row">
    <h1><?= $product->name ?></h1>
    <div class="col-md-6">
        <img src="http://placehold.it/350x260" class="img-responsive" alt="a">
    </div>
    <div class="col-md-6">
        <h5 class="price-text-color"><?= $formatter->asCurrency($product->product->price) ?></h5>
        <p><?= $product->description ?></p>
    </div>
</div>


