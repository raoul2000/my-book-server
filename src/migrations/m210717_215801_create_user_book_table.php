<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m210717_215801_create_user_book_table extends Migration
{
    const TABLE_NAME = '{{%user_book}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'book_id' => $this->string(40)->notNull(),
            'read_status' => $this->smallInteger(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->addForeignKey('{{%fk_user}}', self::TABLE_NAME, 'user_id', '{{%user}}', 'id'); 
        $this->addForeignKey('{{%fk_book}}', self::TABLE_NAME, 'book_id', '{{%book}}', 'id'); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk_user}}', self::TABLE_NAME); 
        $this->dropForeignKey('{{%fk_book}}', self::TABLE_NAME); 

        $this->dropTable(self::TABLE_NAME);
    }
}
