<?php
/* @var $this \yii\web\View */
/* @var $categories \app\modules\shop\domains\category\Category[] */
/* @var $languageCode string */
?>
<div class="row">
    <div class="col-md-12">
        <ul class="list-group">
            <?php $badge = \yii\helpers\Html::tag('span', \app\modules\shop\domains\category\Category::find()->count(), ['class' => 'badge']); ?>
            <?= \yii\helpers\Html::a('Categories' . $badge, ['/shop/category/index'], ['class' => 'list-group-item']) ?>
            <?php $badge = \yii\helpers\Html::tag('span', \app\modules\shop\domains\product\Product::find()->count(), ['class' => 'badge']); ?>
            <?= \yii\helpers\Html::a('Products' . $badge, ['/shop/product/index'], ['class' => 'list-group-item']) ?>
        </ul>
    </div>
</div>
