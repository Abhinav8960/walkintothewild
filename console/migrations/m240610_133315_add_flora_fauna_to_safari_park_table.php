<?php

use yii\db\Migration;

/**
 * Class m240610_133315_add_flora_fauna_to_safari_park_table
 */
class m240610_133315_add_flora_fauna_to_safari_park_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%safari_park}}', 'florafauna', $this->text()->comment('Detail Of Flora and Fauna')->after('module_description'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240610_133315_add_flora_fauna_to_safari_park_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240610_133315_add_flora_fauna_to_safari_park_table cannot be reverted.\n";

        return false;
    }
    */
}
