<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215900_create_book_ping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::BOOK_PING, [
            'id'                => $this->primaryKey(),
            'book_id'           => $this->string(40)->notNull(),
            'is_boarding'       => $this->boolean()->defaultValue(0),
            'email'             => $this->string(),
            'rate'              => $this->tinyInteger(),
            'location_name'     => $this->string(),
            'user_ip'           => $this->string(50),
            'text'              => $this->text(),
            'created_at'        => $this->integer(11),
            'updated_at'        => $this->integer(11)
        ]);

        $this->createIndex('{{%idx-book_ping-book_id}}', TableName::BOOK_PING, 'book_id');
        $this->addForeignKey('{{%fk-book_ping-book_id}}', TableName::BOOK_PING, 'book_id', TableName::BOOK, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-book_ping-book_id}}', TableName::BOOK_PING);
        $this->dropIndex('{{%idx-book_ping-book_id}}', TableName::BOOK_PING);

        $this->dropTable(TableName::BOOK_PING);
    }
}
