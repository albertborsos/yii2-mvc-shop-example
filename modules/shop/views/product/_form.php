<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\shop\services\product\forms\CreateProductForm|\app\modules\shop\services\product\forms\UpdateProductForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(\app\modules\shop\domains\category\Category::dropDownItems(), ['prompt' => Yii::t('app', 'Choose..')]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['class' => 'form-control text-right']) ?>

    <?= $form->field($model, 'imageFile')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/png, image/jpg, image/jpeg',
        ],
        'pluginOptions' => $model->getFileUploadPluginOptions(),
        'pluginEvents' => [
            'filepredelete' => "function(event, key) {
                return (!confirm('" . Yii::t('yii', 'Are you sure you want to delete this item?') . "'));
            }",
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('shop/product', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
