<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\domains\product\Product */

$this->title = Yii::t('shop/product', 'Update Product: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('shop/product', 'Update');
?>
<div class="product-update">

    <div class="row">
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
