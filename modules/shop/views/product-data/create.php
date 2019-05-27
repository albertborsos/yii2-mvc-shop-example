<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\domains\product\ProductData */

$this->title = Yii::t('shop/product-data', 'Create Product Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product-data', 'Product Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
