<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner}}`.
 */
class m240606_132635_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create a new table called 'banner' with the following columns:
        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(), // An integer column for the page ID
            'image' => $this->string(255), // A string column for image with a maximum length of 255 characters
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1), // A tiny integer column for status with a default value of 1 and not null constraint
            'created_at' => $this->integer(), // An integer column for storing the creation timestamp
            'updated_at' => $this->integer(), // An integer column for storing the update timestamp
            'created_by' => $this->integer(), // An integer column for storing the ID of the user who created the record
            'updated_by' => $this->integer(), // An integer column for storing the ID of the user who last updated the record
        ]);

        // Add a unique index to the page_id column
        $this->createIndex(
            'idx-banner-page_id', // Index name
            '{{%banner}}', // Table name
            'page_id', // Column name
            true // Unique index
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banner}}');
    }
}
