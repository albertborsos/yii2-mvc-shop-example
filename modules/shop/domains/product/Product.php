<?php

namespace app\modules\shop\domains\product;

use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Product extends AbstractProduct
{
    use ProductAttributeLabelsTrait;

    const PLACEHOLDER_IMAGE = 'http://placehold.it/350x260';

    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'blameable' => BlameableBehavior::class,
        ];
    }

    /**
     * @param $languageCode
     * @param bool $throwException
     * @return ProductData|array|null|\yii\db\ActiveRecord
     * @throws Exception
     */
    public function data($languageCode, $throwException = true)
    {
        $data = $this->getProductDatas()->andWhere(['language_code' => $languageCode])->one();

        if ($data) {
            return $data;
        }

        if (!$throwException) {
            return null;
        }

        throw new Exception(strtr('No data for this product. {name} - {languageCode}', [
            '{name}' => $this->name,
            '{languageCode}' => $languageCode,
        ]));
    }

    public function getImageUrl()
    {
        /** @var ProductImage $image */
        $image = $this->getProductImages()->orderBy(['id' =>SORT_DESC])->one();

        if (empty($image)) {
            return self::PLACEHOLDER_IMAGE;
        }

        return $image->getUrl();
    }
}
