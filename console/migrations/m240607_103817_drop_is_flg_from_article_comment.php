<?php

use yii\db\Migration;

/**
 * Class m240607_103817_drop_is_flg_from_article_comment
 */
class m240607_103817_drop_is_flg_from_article_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('article_comment', 'is_flag');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240607_103817_drop_is_flg_from_article_comment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240607_103817_drop_is_flg_from_article_comment cannot be reverted.\n";

        return false;
    }
    */
}
