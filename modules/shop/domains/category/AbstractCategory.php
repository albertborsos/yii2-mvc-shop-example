<?php

namespace app\modules\shop\domains\category;

use app\modules\shop\domains\product\Product;
use Yii;

/**
 * This is the model class for table "shop_category".
 *
 * @property int $id
 * @property int $parent_category_id
 * @property string $name
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Category $parentCategory
 * @property Category[] $categories
 * @property CategoryData[] $shopCategoryDatas
 * @property Product[] $shopProducts
 */
abstract class AbstractCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['parent_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop/category', 'ID'),
            'parent_category_id' => Yii::t('shop/category', 'Parent Category ID'),
            'name' => Yii::t('shop/category', 'Name'),
            'created_at' => Yii::t('shop/category', 'Created At'),
            'created_by' => Yii::t('shop/category', 'Created By'),
            'updated_at' => Yii::t('shop/category', 'Updated At'),
            'updated_by' => Yii::t('shop/category', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryDatas()
    {
        return $this->hasMany(CategoryData::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
