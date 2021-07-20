<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210717_215700_create_user_table extends Migration
{
    const TABLE_NAME = '{{%user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'api_key' => $this->string(32)
        ]);
        
        $this->createIndex('idx_user_username', self::TABLE_NAME, 'username', true);
        $this->createIndex('idx_user_email', self::TABLE_NAME, 'email', true);

        $this->insert(self::TABLE_NAME, [
            'id' => '0',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password_hash' => '$2y$13$P/okCIsogd514o21zpBT8uNALHfYyjgeY4.u4EdeovdIbbayrhSka'
        ]);        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}