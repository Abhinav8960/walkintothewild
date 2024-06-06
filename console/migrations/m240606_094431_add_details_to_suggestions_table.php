<?php

use yii\db\Migration;

/**
 * Class m240606_094431_add_details_to_suggestions_table
 */
class m240606_094431_add_details_to_suggestions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%suggestions}}', 'details', $this->text()->comment('Details')->after('you_are_id'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240606_094431_add_details_to_suggestions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240606_094431_add_details_to_suggestions_table cannot be reverted.\n";

        return false;
    }
    */
}
