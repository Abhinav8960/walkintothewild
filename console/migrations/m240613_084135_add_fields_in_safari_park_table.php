<?php

use yii\db\Migration;

/**
 * Class m240613_084135_add_fields_in_safari_park_table
 */
class m240613_084135_add_fields_in_safari_park_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%safari_park}}', 'nearest_railway_station_three', $this->string(255)->after('nearest_railway_station_distance_two'));
        $this->addColumn('{{%safari_park}}', 'nearest_railway_station_distance_three', $this->integer()->after('nearest_railway_station_three'));
        $this->addColumn('{{%safari_park}}', 'nearest_railway_station_four', $this->string(255)->after('nearest_railway_station_distance_three'));
        $this->addColumn('{{%safari_park}}', 'nearest_railway_station_distance_four', $this->integer()->after('nearest_railway_station_four'));
        $this->addColumn('{{%safari_park}}', 'nearest_railway_station_five', $this->string(255)->after('nearest_railway_station_distance_four'));
        $this->addColumn('{{%safari_park}}', 'nearest_railway_station_distance_five', $this->integer()->after('nearest_railway_station_five'));
        
        $this->addColumn('{{%safari_park}}', 'nearest_airport_three', $this->string(255)->after('nearest_airport_distance_two'));
        $this->addColumn('{{%safari_park}}', 'nearest_airport_distance_three', $this->integer()->after('nearest_airport_three'));
        $this->addColumn('{{%safari_park}}', 'nearest_airport_four', $this->string(255)->after('nearest_airport_distance_three'));
        $this->addColumn('{{%safari_park}}', 'nearest_airport_distance_four', $this->integer()->after('nearest_airport_four'));
        $this->addColumn('{{%safari_park}}', 'nearest_airport_five', $this->string(255)->after('nearest_airport_distance_four'));
        $this->addColumn('{{%safari_park}}', 'nearest_airport_distance_five', $this->integer()->after('nearest_airport_five'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240613_084135_add_fields_in_safari_park_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240613_084135_add_fields_in_safari_park_table cannot be reverted.\n";

        return false;
    }
    */
}
