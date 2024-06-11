<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_rare_animal}}`.
 */
class m240610_155517_create_master_rare_animal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%master_rare_animal}}', [
            'id' => $this->primaryKey(),
            'animal_name' => $this->string(255),
            'banner' => $this->string(255),
            'feature_image' => $this->string(255),
            'know_as' => $this->string(255),
            'short_description' => $this->string(512),
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
        $this->dropTable('{{%master_rare_animal}}');
    }
}
