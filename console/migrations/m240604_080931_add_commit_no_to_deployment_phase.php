<?php

use yii\db\Migration;

/**
 * Class m240604_080931_add_commit_no_to_deployment_phase
 */
class m240604_080931_add_commit_no_to_deployment_phase extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%deployment_phase}}', 'commit_no', $this->string(255)->notNull()->comment('Commit Number'));
        $this->addColumn('{{%deployment_phase}}', 'migration', $this->text(45)->notNull()->comment('Migration'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240604_080931_add_commit_no_to_deployment_phase cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240604_080931_add_commit_no_to_deployment_phase cannot be reverted.\n";

        return false;
    }
    */
}
