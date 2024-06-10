<?php

use yii\db\Migration;

/**
 * Class m240610_085513_add_operator_id_to_operator_quote_table
 */
class m240610_085513_add_operator_id_to_operator_quote_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%operator_quote}}', 'operator_id', $this->integer()->comment('Operator Id')->after('id'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240610_085513_add_operator_id_to_operator_quote_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240610_085513_add_operator_id_to_operator_quote_table cannot be reverted.\n";

        return false;
    }
    */
}
