<?php

use yii\db\Migration;

/**
 * Class m240603_112514_create_table_name
 */
class m240603_112514_create_table_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rendered_content', [
            'id' => $this->primaryKey(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rendered_content');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240603_112514_create_table_name cannot be reverted.\n";

        return false;
    }
    */
}
