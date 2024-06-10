<?php

use yii\db\Migration;

/**
 * Class m240610_090117_add_os
 */
class m240610_090117_add_os extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%operator_quote}}', 'os', $this->string()->comment('OS')->after('ip_address'));
        $this->addColumn('{{%operator_quote}}', 'browser', $this->string()->comment('Browser')->after('os'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240610_090117_add_os cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240610_090117_add_os cannot be reverted.\n";

        return false;
    }
    */
}
