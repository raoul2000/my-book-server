<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215950_create_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::SESSION, [
            'id'        => $this->char(40)->notNull(),
            'expire'    => $this->integer(),
            'data'      => $this->binary(),
        ]);
        $this->addPrimaryKey('{{%pk-session}}' , TableName::SESSION, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('{{%pk-session}}', TableName::SESSION);
        $this->dropTable(TableName::SESSION);
    }
}
