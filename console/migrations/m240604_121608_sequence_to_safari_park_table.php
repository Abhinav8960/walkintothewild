<?php

use yii\db\Migration;

/**
 * Class m240604_121608_sequence_to_safari_park_table
 */
class m240604_121608_sequence_to_safari_park_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%safari_park}}', 'sequence', $this->integer()->comment('Sequence'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%safari_park}}', 'sequence');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240604_121608_sequence_to_safari_park_table cannot be reverted.\n";

        return false;
    }
    */
}
