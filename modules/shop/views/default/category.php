<?php
/* @var $this \yii\web\View */
/* @var $category \app\modules\shop\domains\category\CategoryData */
/* @var $products \app\modules\shop\domains\product\Product[] */
/* @var $productData \app\modules\shop\domains\product\ProductData */
/* @var $languageCode $languageCode */
?>
<h1><?= $category->name ?></h1>

<div class="row">
</div>
<?php foreach ($products as $product): ?>
    <?php $productData = $product->data($languageCode) ?>
    <div class="col-md-4">
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
                </div>
                <div class="separator clear-left">
                    <p class="text-center btn-block">
                        <i class="fa fa-list"></i><a href="<?= $productData->getUrl() ?>" class="hidden-sm">More details</a></p>
                </div>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>