<?php

use yii\db\Migration;

/**
 * Class m190520_141826_create_initial_tables
 */
class m190520_141826_create_initial_tables extends Migration
{
    const SHOP_CATEGORY = '{{%shop_category}}';
    const SHOP_CATEGORY_DATA = '{{%shop_category_data}}';

    const SHOP_PRODUCT = '{{%shop_product}}';
    const SHOP_PRODUCT_DATA = '{{%shop_product_data}}';

    const FK_CATEGORY_DATA_CATEGORY_ID_CATEGORY_ID = 'fk_category_data__category_id__category_id';
    const FK_PRODUCT_CATEGORY_ID_CATEGORY_ID = 'fk_product__category_id__category_id';
    const FK_PRODUCT_DATA_PRODUCT_ID_PRODUCT_ID = 'fk_product_data__product_id__product_id';

    public function safeUp()
    {
        $this->createTable(self::SHOP_CATEGORY, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable(self::SHOP_CATEGORY_DATA, [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'language_code' => $this->string(2)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'slug' => $this->string()->notNull(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey(self::FK_CATEGORY_DATA_CATEGORY_ID_CATEGORY_ID, self::SHOP_CATEGORY_DATA, 'category_id', self::SHOP_CATEGORY, 'id');

        $this->createTable(self::SHOP_PRODUCT, [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal()->notNull(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey(self::FK_PRODUCT_CATEGORY_ID_CATEGORY_ID, self::SHOP_PRODUCT, 'category_id', self::SHOP_CATEGORY, 'id');

        $this->createTable(self::SHOP_PRODUCT_DATA, [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'language_code' => $this->string(2)->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey(self::FK_PRODUCT_DATA_PRODUCT_ID_PRODUCT_ID, self::SHOP_PRODUCT_DATA, 'product_id', self::SHOP_PRODUCT, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::FK_PRODUCT_DATA_PRODUCT_ID_PRODUCT_ID, self::SHOP_PRODUCT_DATA);
        $this->dropTable(self::SHOP_PRODUCT_DATA);

        $this->dropForeignKey(self::FK_PRODUCT_CATEGORY_ID_CATEGORY_ID, self::SHOP_PRODUCT);
        $this->dropTable(self::SHOP_PRODUCT);

        $this->dropForeignKey(self::FK_CATEGORY_DATA_CATEGORY_ID_CATEGORY_ID, self::SHOP_CATEGORY_DATA);
        $this->dropTable(self::SHOP_CATEGORY_DATA);

        $this->dropTable(self::SHOP_CATEGORY);
    }
}
