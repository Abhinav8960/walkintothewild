<?php

use yii\db\Migration;

/**
 * Class m240607_103133_add_ip_address_to_article_comment_table
 */
class m240607_103133_add_ip_address_to_article_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%article_comment}}', 'ip_address', $this->string(255)->comment('IP address')->after('comment_datetime'));
        $this->addColumn('{{%article_comment}}', 'device_type', $this->string(255)->comment('Device Type')->after('ip_address'));
        $this->addColumn('{{%article_comment}}', 'browser', $this->string(255)->comment('Browser')->after('device_type'));
        $this->addColumn('{{%article_comment}}', 'os', $this->string(255)->comment('os')->after('browser'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240607_103133_add_ip_address_to_article_comment_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240607_103133_add_ip_address_to_article_comment_table cannot be reverted.\n";

        return false;
    }
    */
}
