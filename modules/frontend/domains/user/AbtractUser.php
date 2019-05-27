<?php

namespace app\modules\frontend\domains\user;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $google_id
 * @property string $name
 * @property string $picture
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
abstract class AbtractUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['google_id', 'name', 'picture'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'google_id' => Yii::t('user', 'Google ID'),
            'name' => Yii::t('user', 'Name'),
            'picture' => Yii::t('user', 'Picture'),
            'created_at' => Yii::t('user', 'Created At'),
            'created_by' => Yii::t('user', 'Created By'),
            'updated_at' => Yii::t('user', 'Updated At'),
            'updated_by' => Yii::t('user', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
