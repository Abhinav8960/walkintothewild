<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%frontend_error_log}}`.
 */
class m240604_112033_create_frontend_error_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%frontend_error_log}}', [
            'id' => $this->primaryKey(),
            'request_url' => $this->string(255)->notNull(),
            'request_type' => $this->string(255)->notNull(),
            'reference_url' => $this->string(255),
            'error_type' => $this->string(255)->notNull(),
            'ip_address' => $this->string(255),
            'error_msg' => $this->text(),
            'source' => $this->string(255),
            'user_agent' => $this->string(),
            'user_session_id' => $this->integer(),
            'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%frontend_error_log}}');
    }
}
