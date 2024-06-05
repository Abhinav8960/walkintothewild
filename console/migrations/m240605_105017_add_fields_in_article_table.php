<?php

use yii\db\Migration;

/**
 * Class m240605_105017_add_fields_in_article_table
 */
class m240605_105017_add_fields_in_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%article}}', 'article_tag_id', $this->integer()->null()->after('description'));
        $this->addColumn('{{%article}}', 'tag_name', $this->text()->null()->after('article_tag_id'));
        $this->addColumn('{{%article}}', 'date', $this->date()->null()->after('meta_keywords'));
        $this->date('{{%article}}', 'view', $this->integer()->null());
        $this->addColumn('{{%article}}', 'sequence', $this->integer()->comment('Sequence')->after('publish_date_time'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240605_105017_add_fields_in_article_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240605_105017_add_fields_in_article_table cannot be reverted.\n";

        return false;
    }
    */
}
