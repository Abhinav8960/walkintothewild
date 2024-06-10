<?php

use yii\db\Migration;

/**
 * Class m240610_083348_operator_quote_table
 */
class m240610_083348_operator_quote_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operator_quote}}', [
            'id' => $this->primaryKey(),
            'safari_park_id' => $this->integer(), // An integer column for the safari park ID
            'safaris' => $this->integer(), // An integer column for the safaris count
            'travelers' => $this->integer(), // An integer column for the traveler count
            'stay_category_id' => $this->integer(), // An integer column for the stay category id
            'full_name' => $this->string(255), // A string column for full name with a maximum length of 255 characters
            'email' => $this->string(255), // A string column for email with a maximum length of 255 characters
            'phone_no' => $this->string(12), // A string column for phone number with a maximum length of 255 characters
            'start_date' => $this->string(255), // A string column for start_date with a maximum length of 255 characters
            'end_date' => $this->string(255), // A string column for end_date with a maximum length of 255 characters
            'user_agent' => $this->string(), // A string column for user agent with a maximum length of 255 characters
            'ip_address' => $this->string(45), // A string column for ip address with a maximum length of 255 characters
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1), // A tiny integer column for status with a default value of 1 and not null constraint
            'created_at' => $this->integer(), // An integer column for storing the creation timestamp
            'updated_at' => $this->integer(), // An integer column for storing the update timestamp
            'created_by' => $this->integer(), // An integer column for storing the ID of the user who created the record
            'updated_by' => $this->integer(), // An integer column for storing the ID of the user who last updated the record
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operator_quote}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240610_083348_operator_quote_table cannot be reverted.\n";

        return false;
    }
    */
}
