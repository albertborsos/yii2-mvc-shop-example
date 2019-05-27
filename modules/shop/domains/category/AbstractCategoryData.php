<?php

namespace app\modules\shop\domains\category;

use Yii;

/**
 * This is the model class for table "shop_category_data".
 *
 * @property int $id
 * @property int $category_id
 * @property string $language_code
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Category $category
 */
abstract class AbstractCategoryData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_category_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'language_code', 'name', 'slug'], 'required'],
            [['category_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['language_code'], 'string', 'max' => 2],
            [['name', 'slug'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryDataQuery(get_called_class());
    }
}
