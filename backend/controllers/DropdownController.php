<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\Helpers\LocationHelper;
use common\models\master\city\MasterCity;
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
}
