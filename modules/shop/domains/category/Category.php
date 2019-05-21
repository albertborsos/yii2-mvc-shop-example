<?php

namespace app\modules\shop\domains\category;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Category extends AbstractCategory
{
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
}
