<?php

use yii\db\Migration;

use yii\db\Schema;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210717_215701_create_user_token_table extends Migration
{
    const TABLE_NAME = '{{%user_token}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'token' => $this->string()->notNull(),
            'data' => $this->string(),
            'created_at' => $this->dateTime(),
            'expire_at' => $this->dateTime()
        ]);

        $this->addForeignKey('{{%user_token_user_id}}', self::TABLE_NAME, 'user_id', '{{%user}}', 'id');      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%user_token_user_id}}', self::TABLE_NAME);
        
        $this->dropTable(self::TABLE_NAME);
    }
}
