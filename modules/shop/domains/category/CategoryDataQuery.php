<?php

namespace app\modules\shop\domains\category;

/**
 * This is the ActiveQuery class for [[CategoryData]].
 *
 * @see CategoryData
 */
class CategoryDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CategoryData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CategoryData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
