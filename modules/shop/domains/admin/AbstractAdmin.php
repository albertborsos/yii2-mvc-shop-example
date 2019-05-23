<?php

namespace app\modules\shop\domains\admin;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
abstract class AbstractAdmin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['username', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'username' => Yii::t('admin', 'Username'),
            'password' => Yii::t('admin', 'Password'),
            'created_at' => Yii::t('admin', 'Created At'),
            'created_by' => Yii::t('admin', 'Created By'),
            'updated_at' => Yii::t('admin', 'Updated At'),
            'updated_by' => Yii::t('admin', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminQuery(get_called_class());
    }
}
