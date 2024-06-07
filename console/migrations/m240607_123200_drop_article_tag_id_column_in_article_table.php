<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%article_tag_id_column_in_article}}`.
 */
class m240607_123200_drop_article_tag_id_column_in_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('article', 'article_tag_id');
        $this->dropColumn('article', 'tag_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240607_123200_drop_article_tag_id_column_in_article_table cannot be reverted.\n";

        return false;
    }
}
