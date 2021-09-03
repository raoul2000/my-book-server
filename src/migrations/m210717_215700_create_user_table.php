<?php

namespace app\migrations;

use yii\db\Migration;

class m210717_215700_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableName::USER, [
            'id'            => $this->primaryKey(),
            'username'      => $this->string()->notNull()->unique(),
            'email'         => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'status'        => $this->smallInteger()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime()
        ]);

        $this->createIndex('{{%idx_user_username}}', TableName::USER, 'username', true);
        $this->createIndex('{{%idx_user_email}}', TableName::USER, 'email', true);

        $this->insert(TableName::USER, [
            'id'            => '0',
            'username'      => 'admin',
            'email'         => 'admin@email.com',
            'password_hash' => '$2y$13$P/okCIsogd514o21zpBT8uNALHfYyjgeY4.u4EdeovdIbbayrhSka',
            'status'        => 10 // ACTIVE
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx_user_username}}', TableName::USER);
        $this->dropIndex('{{%idx_user_email}}', TableName::USER);

        $this->dropTable(TableName::USER);
    }
}
