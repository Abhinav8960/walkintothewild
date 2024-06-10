<?php

use yii\db\Migration;

/**
 * Class m240610_142707_add_animals_to_safari_park_table
 */
class m240610_142707_add_animals_to_safari_park_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%safari_park}}', 'animal_text', $this->text()->comment('Detail Animals')->after('florafauna'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240610_142707_add_animals_to_safari_park_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240610_142707_add_animals_to_safari_park_table cannot be reverted.\n";

        return false;
    }
    */
}
