<?php

use yii\db\Migration;

/**
 * Class m240607_124124_rename_column_in_article_tag_table
 */
class m240607_124124_rename_column_in_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('article_tag', 'master_article_topic_id', 'master_article_tag_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240607_124124_rename_column_in_article_tag_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240607_124124_rename_column_in_article_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
