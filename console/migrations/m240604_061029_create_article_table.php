<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m240604_061029_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTableIfExists('{{%article}}');

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(300)->notNull(),
            'sub_title' => $this->string(75),
            'description' => $this->text(),
            'banner' => $this->string(255),
            'feature_image' => $this->string(255),
            'article_author_id' => $this->integer(),
            'author_name' => $this->string(255),
            'meta_title' => $this->string(255)->notNull(),
            'meta_description' => $this->text(),
            'meta_keywords' => $this->text(),
            'view' => $this->integer()->notNull()->defaultValue(0),
            'post_body' => $this->binary(),
            'comment_allowed' => $this->integer(),
            'approval_required' => $this->integer(),
            'is_schedule' => $this->integer(),
            'publish_date_time' => $this->dateTime(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }


     /**
     * Drops the table if it exists.
     *
     * @param string $table
     */
    private function dropTableIfExists($table)
    {
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->dropTable($table);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }
}
