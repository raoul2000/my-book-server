<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215801_create_user_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::USER_BOOK, [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->notNull(),
            'book_id'       => $this->string(40)->notNull(),
            'read_status'   => $this->smallInteger(),
            'rate'          => $this->smallInteger(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime()
        ]);

        $this->addForeignKey('{{%fk_user_book-user_id}}', TableName::USER_BOOK, 'user_id', TableName::USER, 'id');
        $this->addForeignKey('{{%fk_user_book-book_id}}', TableName::USER_BOOK, 'book_id', TableName::BOOK, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk_user_book-user_id}}', TableName::USER_BOOK);
        $this->dropForeignKey('{{%fk_user_book-book_id}}', TableName::USER_BOOK);

        $this->dropTable(TableName::USER_BOOK);
    }
}
