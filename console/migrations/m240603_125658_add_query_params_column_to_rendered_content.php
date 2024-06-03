<?php

use yii\db\Migration;

/**
 * Class m240603_125658_add_query_params_column_to_rendered_content
 */
class m240603_125658_add_query_params_column_to_rendered_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rendered_content}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'url' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'action_url' => $this->string()->notNull(),
            'query_params' => $this->text()->comment('Query Parameters'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rendered_content}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240603_125658_add_query_params_column_to_rendered_content cannot be reverted.\n";

        return false;
    }
    */
}
