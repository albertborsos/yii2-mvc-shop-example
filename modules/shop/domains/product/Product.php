<?php

namespace app\modules\shop\domains\product;

use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Product extends AbstractProduct
{
    use ProductAttributeLabelsTrait;

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
     * @return Product|array|null|\yii\db\ActiveRecord
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
}
