<?php

use yii\db\Migration;

/**
 * Class m240605_133005_update_column_type_frontend_error
 */
class m240605_133005_update_column_type_frontend_error extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240605_133005_update_column_type_frontend_error cannot be reverted.\n";

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('{{%frontend_error_log}}', 'request_url', $this->text());
        $this->alterColumn('{{%frontend_error_log}}', 'reference_url', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // Note: You should adjust this if your original column type was different
        $this->alterColumn('{{%frontend_error_log}}', 'request_url', $this->string(255));
        $this->alterColumn('{{%frontend_error_log}}', 'reference_url', $this->string(255));
    }
}
