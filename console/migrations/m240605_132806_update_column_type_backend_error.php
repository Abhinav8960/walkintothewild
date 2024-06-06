<?php

use yii\db\Migration;

/**
 * Class m240605_132806_update_column_type_backend_error
 */
class m240605_132806_update_column_type_backend_error extends Migration
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
        echo "m240605_132806_update_column_type_backend_error cannot be reverted.\n";

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('{{%backend_error_log}}', 'request_url', $this->text());
        $this->alterColumn('{{%backend_error_log}}', 'reference_url', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // Note: You should adjust this if your original column type was different
        $this->alterColumn('{{%backend_error_log}}', 'request_url', $this->string(255));
        $this->alterColumn('{{%backend_error_log}}', 'reference_url', $this->string(255));
    }
}
