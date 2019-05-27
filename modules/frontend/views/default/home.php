<?php
/* @var $this \yii\web\View */
/* @var $latestProducts \app\modules\shop\domains\product\Product[]|array */
/* @var $languageCode $languageCode */
/* @var $formatter \yii\i18n\Formatter */
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= Yii::t('app', 'Latest Products') ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php foreach ($latestProducts as $product): ?>
                        <?php $productData = $product->data($languageCode) ?>
                        <div class="col-md-4">
                            <?= $this->render('_product-item', [
                                'productData' => $productData,
                                'formatter' => $formatter,
                            ]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
