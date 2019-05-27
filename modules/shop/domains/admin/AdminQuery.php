<?php

namespace app\modules\shop\domains\admin;

/**
 * This is the ActiveQuery class for [[AbtractAdmin]].
 *
 * @see AbstractAdmin
 */
class AdminQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AbstractAdmin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AbstractAdmin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
