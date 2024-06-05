<?php

use yii\db\Migration;

/**
 * Class m240605_134105_add_fields_in_master_article_tag_table
 */
class m240605_134105_add_fields_in_master_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%master_article_tag}}', 'sequence', $this->integer()->comment('Sequence')->after('slug'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240605_134105_add_fields_in_master_article_tag_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240605_134105_add_fields_in_master_article_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
