<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215701_create_user_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::USER_TOKEN, [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->notNull(),
            'type'          => $this->smallInteger()->notNull(),
            'token'         => $this->string()->notNull(),
            'data'          => $this->string(),
            'created_at'    => $this->integer(11),
            'expire_at'     => $this->integer(11)
        ]);

        $this->addForeignKey('{{%fk_user_token-user_id}}', TableName::USER_TOKEN, 'user_id', TableName::USER, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk_user_token-user_id}}', TableName::USER_TOKEN);

        $this->dropTable(TableName::USER_TOKEN);
    }
}
