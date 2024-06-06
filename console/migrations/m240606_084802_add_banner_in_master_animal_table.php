<?php

use yii\db\Migration;

/**
 * Class m240606_084802_add_banner_in_master_animal_table
 */
class m240606_084802_add_banner_in_master_animal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%master_animal}}', 'banner_image', $this->string()->null()->after('image'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240606_084802_add_banner_in_master_animal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240606_084802_add_banner_in_master_animal_table cannot be reverted.\n";

        return false;
    }
    */
}
