<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210717_215900_create_book_review_table extends Migration
{
    const TABLE_NAME = '{{%book_review}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'book_id' => $this->string(32)->notNull(),
            'email' => $this->string(),
            'rate' => $this->tinyInteger(),
            'location_name' => $this->string(),
            'user_ip' => $this->string(50),
            'text' => $this->text(),
            'created_at' => $this->dateTime()
        ]);


        $this->createIndex(
            'idx-book_review-book_id',
            self::TABLE_NAME,
            'book_id'
        );

        $this->addForeignKey(
            'fk-book_review-book_id',
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
            'fk-book_review-book_id',
            '{{%book}}'
        );

        $this->dropIndex(
            'idx-book_review-book_id',
            self::TABLE_NAME
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
