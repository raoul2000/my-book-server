<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215900_create_book_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::BOOK_REVIEW, [
            'id'                => $this->primaryKey(),
            'book_id'           => $this->string(40)->notNull(),
            'email'             => $this->string(),
            'rate'              => $this->tinyInteger(),
            'location_name'     => $this->string(),
            'user_ip'           => $this->string(50),
            'text'              => $this->text(),
            'created_at'        => $this->dateTime()
        ]);

        $this->createIndex('{{%idx-book_review-book_id}}', TableName::BOOK_REVIEW, 'book_id');
        $this->addForeignKey('{{%fk-book_review-book_id}}', TableName::BOOK_REVIEW, 'book_id', '{{%book}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-book_review-book_id}}', TableName::BOOK_REVIEW);
        $this->dropIndex('{{%idx-book_review-book_id}}', TableName::BOOK_REVIEW);

        $this->dropTable(TableName::BOOK_REVIEW);
    }
}
