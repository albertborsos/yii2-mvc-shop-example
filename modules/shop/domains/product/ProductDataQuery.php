<?php

namespace app\modules\shop\domains\product;

/**
 * This is the ActiveQuery class for [[ProductData]].
 *
 * @see ProductData
 */
class ProductDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
