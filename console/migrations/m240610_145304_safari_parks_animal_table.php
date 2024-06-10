<?php

use yii\db\Migration;

/**
 * Class m240610_145304_safari_parks_animal_table
 */
class m240610_145304_safari_parks_animal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTableIfExists('{{%safari_parks_animal}}');

        $this->createTable('{{%safari_parks_animal}}', [
            'id' => $this->primaryKey(),
            'safari_park_id' => $this->integer(),
            'master_animal_id' => $this->integer(),
            'animal_type_id' => $this->integer(),
            'animal_name' => $this->string(255),
            'article_author_id' => $this->integer(),
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
        echo "m240610_145304_safari_parks_animal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240610_145304_safari_parks_animal_table cannot be reverted.\n";

        return false;
    }
    */
}
