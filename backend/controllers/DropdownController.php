<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\Helpers\LocationHelper;
use common\models\master\airport\MasterAirport;
use common\models\master\city\MasterCity;
use common\models\master\location\MasterLocation;
use common\models\master\railwaystation\MasterRailwayStation;
use common\models\master\state\MasterState;

/**
 * Dropdown controller
 */
class DropdownController extends Controller
{

    public function actionGetstate($country_id)
    {

        $states = MasterState::find()->where(['country_id' => $country_id, 'status' => 1])->all();
        echo "<option value=''>Select State</option>";
        $stateList = $states;
        foreach ($stateList as $state) {
            echo "<option value='" . $state->id . "'>" . $state->state_name . "</option>";
        }
    }

    public function actionGetcity($master_state_id)
    {

        $cities = MasterCity::find()->where(['state_id' => $master_state_id, 'status' => 1])->all();
        echo "<option value=''>Select City</option>";
        $cityList = $cities;
        foreach ($cityList as $city) {
            echo "<option value='" . $city->id . "'>" . $city->city_name . "</option>";
        }
    }

    public function actionGetrailway($master_city_id)
    {
        $railwayStations = MasterRailwayStation::find()->where(['city_id' => $master_city_id, 'status' => 1])->all();
        echo "<option value=''>Select Railway Station</option>";
        $railwayStationList = $railwayStations;
        foreach ($railwayStationList as $railwayStation) {
            echo "<option value='" . $railwayStation->id . "'>" . $railwayStation->title . "</option>";
        }
    }

    public function actionGetairport($master_city_id)
    {
        $airports = MasterAirport::find()->where(['city_id' => $master_city_id, 'status' => 1])->all();
        echo "<option value=''>Select Airport</option>";
        $airportList = $airports;
        foreach ($airportList as $airport) {
            echo "<option value='" . $airport->id . "'>" . $airport->name . "</option>";
        }
    }

    public function actionGetlocation($master_city_id)
    {
        $locations = MasterLocation::find()->where(['city_id' => $master_city_id, 'status' => 1])->all();
        echo "<option value=''>Select Location</option>";
        $locationList = $locations;
        foreach ($locationList as $location) {
            echo "<option value='" . $location->id . "'>" . $location->title . "</option>";
        }
    }
}
