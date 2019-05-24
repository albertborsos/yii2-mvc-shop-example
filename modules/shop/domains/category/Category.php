<?php

namespace app\modules\shop\domains\category;

use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Category extends AbstractCategory
{
    use CategoryAttributeLabelsTrait;

    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'blameable' => BlameableBehavior::class,
        ];
    }

    public static function dropDownItems()
    {
        return ArrayHelper::map(static::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    /**
     * @param $languageCode
     * @param bool $throwException
     * @return CategoryData|array|null|\yii\db\ActiveRecord
     * @throws Exception
     */
    public function data($languageCode, $throwException = true)
    {
        $data = $this->getCategoryDatas()->andWhere(['language_code' => $languageCode])->one();

        if ($data) {
            return $data;
        }

        if (!$throwException) {
            return null;
        }

        throw new Exception(strtr('No data for this category. {name} - {languageCode}', [
            '{name}' => $this->name,
            '{languageCode}' => $languageCode,
        ]));
    }
}
