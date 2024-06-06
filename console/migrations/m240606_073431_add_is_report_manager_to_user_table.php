<?php

use yii\db\Migration;

/**
 * Class m240606_073431_add_is_report_manager_to_user_table
 */
class m240606_073431_add_is_report_manager_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'is_report_manager', $this->integer()->notNull()->defaultValue(0)->comment('Reporting Manager')->after('is_resort_manager'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240606_073431_add_is_report_manager_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240606_073431_add_is_report_manager_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
