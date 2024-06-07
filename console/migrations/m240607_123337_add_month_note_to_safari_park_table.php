<?php

use yii\db\Migration;

/**
 * Class m240607_123337_add_month_note_to_safari_park_table
 */
class m240607_123337_add_month_note_to_safari_park_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%safari_park}}', 'month_note', $this->string(255)->comment('Month Note')->after('longitude'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240607_123337_add_month_note_to_safari_park_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240607_123337_add_month_note_to_safari_park_table cannot be reverted.\n";

        return false;
    }
    */
}
