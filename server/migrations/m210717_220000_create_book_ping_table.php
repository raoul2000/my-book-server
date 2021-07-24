<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210717_220000_create_book_ping_table extends Migration
{
    const TABLE_NAME = '{{%book_ping}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'book_id' => $this->string(32)->notNull(),
            'user_ip' => $this->string(50),
            'created_at' => $this->dateTime()
        ]);


        $this->createIndex(
            'idx-book_ping-book_id',
            self::TABLE_NAME,
            'book_id'
        );

        $this->addForeignKey(
            'fk-book_ping-book_id',
            self::TABLE_NAME,
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-book_ping-book_id',
            '{{%book}}'
        );

        $this->dropIndex(
            'idx-book_ping-book_id',
            self::TABLE_NAME
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
