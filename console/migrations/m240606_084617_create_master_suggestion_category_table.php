<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_suggestion_category}}`.
 */
class m240606_084617_create_master_suggestion_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTableIfExists('{{%master_suggestion_category}}');

        $this->createTable('{{%master_suggestion_category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
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
        $this->dropTable('{{%master_suggestion_category}}');
    }
}
