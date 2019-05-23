<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\domains\category\CategoryData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-data-form">

    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php if ($model->hasProperty('slug')): ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>

        <?= $form->field($model, 'description')->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('shop/category-data', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>


</div>
