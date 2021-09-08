<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215820_create_book_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::BOOK_TICKET, [
            'id'            => $this->string(40),
            'user_id'       => $this->integer()->notNull(),
            'book_id'       => $this->string(40)->notNull(),
            'departure_at'  => $this->dateTime(),
            'from'          => $this->string(255),
            'created_at'    => $this->integer(11),
            'updated_at'    => $this->integer(11)
        ]);

        $this->addPrimaryKey('id', TableName::BOOK_TICKET,'id');
        $this->addForeignKey('{{%fk_book_ticket-user_id}}', TableName::BOOK_TICKET, 'user_id', TableName::USER, 'id');
        $this->addForeignKey('{{%fk_book_ticket-book_id}}', TableName::BOOK_TICKET, 'book_id', TableName::BOOK, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk_book_ticket-user_id}}', TableName::BOOK_TICKET);
        $this->dropForeignKey('{{%fk_book_ticket-book_id}}', TableName::BOOK_TICKET);

        $this->dropTable(TableName::BOOK_TICKET);
    }
}
