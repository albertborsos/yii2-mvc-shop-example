<?php
/* @var $this \yii\web\View */
/* @var $category \app\modules\shop\domains\category\CategoryData */
/* @var $products \app\modules\shop\domains\product\Product[] */
/* @var $productData \app\modules\shop\domains\product\ProductData */
/* @var $productsDataProvider \yii\data\ActiveDataProvider */
/* @var $languageCode $languageCode */
?>
<h1><?= $category->name ?></h1>

<div class="row">
    <div class="col-md-12">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $productsDataProvider,
            'itemOptions' => ['class' => 'col-md-4'],
            'itemView' => function ($model, $key, $index, $widget) use ($languageCode) {
                return $this->render('_product-item', [
                    'productData' => $model->data($languageCode),
                ]);
            },
            'pager' => [
                'options' => ['class' => 'pagination col-md-12'],
            ],
        ]) ?>
    </div>
</div>