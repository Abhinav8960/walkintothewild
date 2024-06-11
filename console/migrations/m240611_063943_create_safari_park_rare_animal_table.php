<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%safari_park_rare_animal}}`.
 */
class m240611_063943_create_safari_park_rare_animal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%safari_park_rare_animal}}', [
            'id' => $this->primaryKey(),
            'safari_park_id' => $this->integer(),
            'master_rare_animal_id' => $this->integer(),
            'animal_name' => $this->string(255),
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
        $this->dropTable('{{%safari_park_rare_animal}}');
    }
}
