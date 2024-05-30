<?php



use yii\db\Migration;
use yii\di\Instance;

/**
 * Class m231117_102354_alter_audit_entry
 */
class m231117_102354_alter_audit_entry extends Migration
{
    const TABLE = '{{%audit_entry}}';

     public function getDb()
    {
        return Yii::$app->db_audit_frontend; // Use the second database connection
    }


    public function up()
    {
        $this->alterColumn(self::TABLE, 'user_id', $this->string(255)->null()->defaultValue(0));
    }
}
