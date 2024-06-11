<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%master_animal}}`.
 */
class m240611_060644_drop_columns_from_master_animal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('master_animal', 'animal_type_id');
        $this->dropColumn('master_animal', 'know_as');
        $this->dropColumn('master_animal', 'long_description');
        $this->dropColumn('master_animal', 'image');
        $this->dropColumn('master_animal', 'banner_image');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
