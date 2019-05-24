<?php
/* @var $this \yii\web\View */
/* @var $categories \app\modules\shop\domains\category\Category[] */
/* @var $languageCode string */
?>
<div class="row">
    <div class="col-md-12">
        <ul class="list-group">
            <?php foreach ($categories as $category): ?>
                <?php $badge = \yii\helpers\Html::tag('span', $category->getProducts()->count(), ['class' => 'badge']); ?>
                <?= \yii\helpers\Html::a($category->name . $badge, $category->data($languageCode)->getUrl(), ['class' => 'list-group-item']) ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
