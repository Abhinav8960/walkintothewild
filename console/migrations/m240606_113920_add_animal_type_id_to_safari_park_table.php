<?php

use yii\db\Migration;

/**
 * Class m240606_113920_add_animal_type_id_to_safari_park_table
 */
class m240606_113920_add_animal_type_id_to_safari_park_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%safari_parks_animal}}', 'animal_type_id', $this->integer()->comment('Animal Type')->after('master_animal_id'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240606_113920_add_animal_type_id_to_safari_park_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240606_113920_add_animal_type_id_to_safari_park_table cannot be reverted.\n";

        return false;
    }
    */
}
