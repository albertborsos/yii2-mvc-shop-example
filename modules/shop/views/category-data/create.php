<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\domains\category\CategoryData */

$this->title = Yii::t('shop/category-data', 'Create Category Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/category-data', 'Category Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
