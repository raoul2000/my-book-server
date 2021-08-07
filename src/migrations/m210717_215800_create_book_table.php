<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m210717_215800_create_book_table extends Migration
{
    const TABLE_NAME = '{{%book}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->string(40)->notNull()->unique(),
            'title' => $this->string(255)->notNull(),
            'author' => $this->string(255),
            'isbn' => $this->string(15),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        
        $this->createIndex('idx_book_book_id', self::TABLE_NAME, 'id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_book_book_id',self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
