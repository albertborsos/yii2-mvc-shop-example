<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\domains\product\ProductData */

$this->title = Yii::t('shop/product-data', 'Update Product Data: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product-data', 'Product Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('shop/product-data', 'Update');
?>
<div class="product-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
