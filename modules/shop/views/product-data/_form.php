<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\domains\product\ProductData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'slug-source form-control']) ?>

    <?php if ($model->hasProperty('slug')): ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'slug-result form-control']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('shop/product-data', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
