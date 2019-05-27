<?php

use yii\db\Migration;

/**
 * Class m190523_141240_create_user_and_admin_tables
 */
class m190523_141240_create_user_and_admin_tables extends Migration
{
    const ADMIN = '{{%admin}}';
    const USER = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::USER, [
            'id' => $this->primaryKey(),
            'google_id' => $this->string(),
            'name' => $this->string(),
            'picture' => $this->string(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable(self::ADMIN, [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'password' => $this->string(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->insert(self::ADMIN, [
            'username' => 'admin',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::ADMIN);
        $this->dropTable(self::USER);
    }
}
