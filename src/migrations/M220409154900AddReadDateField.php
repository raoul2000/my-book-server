<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class M220409154900AddReadDateField
 */
class M220409154900AddReadDateField extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(TableName::USER_BOOK, 'read_at', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(TableName::USER_BOOK, 'read_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M220409154900AddReadDateField cannot be reverted.\n";

        return false;
    }
    */
}
