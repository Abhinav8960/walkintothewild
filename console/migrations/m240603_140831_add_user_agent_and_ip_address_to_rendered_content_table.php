<?php

use yii\db\Migration;

/**
 * Class m240603_140831_add_user_agent_and_ip_address_to_rendered_content_table
 */
class m240603_140831_add_user_agent_and_ip_address_to_rendered_content_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rendered_content}}', 'user_agent', $this->string()->notNull()->comment('User Agent'));
        $this->addColumn('{{%rendered_content}}', 'ip_address', $this->string(45)->notNull()->comment('IP Address'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rendered_content}}', 'user_agent');
        $this->dropColumn('{{%rendered_content}}', 'ip_address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240603_140831_add_user_agent_and_ip_address_to_rendered_content_table cannot be reverted.\n";

        return false;
    }
    */
}
