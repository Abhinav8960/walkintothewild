<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%safari_suggestions}}`.
 */
class m240606_110128_create_safari_suggestions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%safari_suggestions}}', [
            'id' => $this->primaryKey(),
            'park_id' => $this->integer(),
            'master_suggestion_id' => $this->integer(),
            'you_are_id' => $this->integer(),
            'details' => $this->text(),
            'user_agent' => $this->string()->notNull(),
            'ip_address' => $this->string(45)->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%safari_suggestions}}');
    }
}
