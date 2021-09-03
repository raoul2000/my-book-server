<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215800_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::BOOK, [
            'id'            => $this->string(40),
            'title'         => $this->string(255)->notNull(),
            'subtitle'      => $this->string(255)->notNull(),
            'author'        => $this->string(255),
            'isbn'          => $this->string(15),
            'is_traveling'  => $this->boolean()->defaultValue(0),
            'ping_count'    => $this->integer()->defaultValue(0),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime()
        ]);

        $this->addPrimaryKey('id', TableName::BOOK,'id');
        $this->createIndex('{{%idx_book_book_id}}', TableName::BOOK, 'id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx_book_book_id}}', TableName::BOOK);
        $this->dropTable(TableName::BOOK);
    }
}
