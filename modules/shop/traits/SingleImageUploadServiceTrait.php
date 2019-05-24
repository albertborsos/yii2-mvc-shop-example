<?php

namespace app\modules\shop\traits;

use app\modules\shop\domains\product\Product;
use app\modules\shop\domains\product\ProductImage;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

trait SingleImageUploadServiceTrait
{
    private function storeImage(Product $product)
    {
        if (empty($this->form->imageFile)) {
            return;
        }

        $image = new ProductImage([
            'product_id' => $product->id,
            'title' => $product->name,
        ]);

        $image = $this->generateFileName($image, $this->form->imageFile);

        if ($this->storeFile($image, $this->form->imageFile) === false) {
            throw new Exception('Unable to store image.');
        }

        $image->save();
    }

    private function generateFileName(ProductImage $model, UploadedFile $uploadedFile)
    {
        $fileName = strtolower(Yii::$app->security->generateRandomString(20)) . '.' . $uploadedFile->getExtension();

        if (ProductImage::findOne(['filename' => $fileName]) === null) {
            $model->filename = $fileName;

            return $model;
        }

        return $this->generateFileName($model, $uploadedFile);
    }


    private function storeFile(ProductImage $model, UploadedFile $uploadedFile)
    {
        $folder = dirname($this->getSavePath($model));
        if (!is_dir($folder)) {
            FileHelper::createDirectory($folder);
        }

        return $uploadedFile->saveAs($this->getSavePath($model));
    }

    private function getSavePath(ProductImage $model)
    {
        return Yii::getAlias(rtrim(self::SAVE_PATH, '/') . '/' . $model->filename);
    }
}
