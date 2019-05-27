<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\domains\category\Category */

$this->title = Yii::t('shop/category', 'Update Category: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('shop/category', 'Update');
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= \yii\bootstrap\Tabs::widget([
                'items' => \app\modules\shop\domains\category\CategoryData::updateTabItems($this, $form),
            ]) ?>
        </div>
    </div>


</div>
