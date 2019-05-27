<?php

namespace app\modules\frontend\domains\user;

/**
 * This is the ActiveQuery class for [[AbtractUser]].
 *
 * @see AbtractUser
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AbtractUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AbtractUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
