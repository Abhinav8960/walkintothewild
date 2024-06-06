<?php

use yii\db\Migration;

/**
 * Class m240605_143432_add_animal_type_sequence_in_table
 */
class m240605_143432_add_animal_type_sequence_in_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%safari_park}}', 'animal_type_sequence', $this->integer()->after('sequence'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240605_143432_add_animal_type_sequence_in_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240605_143432_add_animal_type_sequence_in_table cannot be reverted.\n";

        return false;
    }
    */
}
