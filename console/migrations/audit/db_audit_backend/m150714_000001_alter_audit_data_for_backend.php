<?php



use yii\db\Migration;
use yii\db\Schema;

class m150714_000001_alter_audit_data_for_backend extends Migration
{
    const TABLE = '{{%audit_data}}';
     public function getDb()
    {
        return Yii::$app->db_audit_backend; // Use the second database connection
    }

    

    public function up()
    {
        $this->addColumn(self::TABLE, 'created', Schema::TYPE_DATETIME);
    }

}
