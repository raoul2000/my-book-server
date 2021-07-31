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
            'api_key' => $this->string(32),
            'status' => $this->smallInteger()->notNull(),
            'account_activation_token' => $this->string(),    
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()            
        ]);
        
        $this->createIndex('idx_user_username', self::TABLE_NAME, 'username', true, 'NOW()');
        $this->createIndex('idx_user_email', self::TABLE_NAME, 'email', true, 'NOW()');

        $this->insert(self::TABLE_NAME, [
            'id' => '0',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password_hash' => '$2y$13$P/okCIsogd514o21zpBT8uNALHfYyjgeY4.u4EdeovdIbbayrhSka',
            'status' => 10 // ACTIVE
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
