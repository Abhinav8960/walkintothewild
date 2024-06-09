<?php

use yii\db\Migration;

/**
 * Class m240607_185941_add_is_filter_to_master_animal_table
 */
class m240607_185941_add_is_filter_to_master_animal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%master_animal}}', 'is_filter', $this->integer()->comment('Is Filter')->after('banner_image'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240607_185941_add_is_filter_to_master_animal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240607_185941_add_is_filter_to_master_animal_table cannot be reverted.\n";

        return false;
    }
    */
}
