<?php

namespace api\models\park;

use Yii;
use api\models\master\city\MasterCity;
use api\models\park\SafariParkAnimal;
use api\models\master\state\MasterState;
use api\models\operator\SafariOperatorPark;
use api\models\master\airport\MasterAirport;
use api\models\master\animal\MasterAnimal;
use api\models\master\country\MasterCountry;
use api\models\master\location\MasterLocation;
use api\models\master\month\MasterMonth;
use api\models\master\railwaystation\MasterRailwayStation;
use api\models\master\vehicle\MasterVehicle;
use api\models\meta\MetaAccommodation;
use api\models\meta\MetaSafariSession;
use api\models\operator\SafariOperator;
use api\models\sharesafari\ShareSafari;
use api\models\suggestions\SafariSuggestions;
use api\models\UserExperience;
use common\models\park\SafariParkMonth;

class SafariPark extends \common\models\park\SafariPark
{

    public function fields()
    {
        $fields = parent::fields();

        if (!in_array(\Yii::$app->controller->action->uniqueId, ['park/default/filter-parklist', 'sharesafari/default/index', 'sharesafari/default/view', 'package/default/view', 'package/default/index'])) {
            $fields[] = 'featureimagepath';
            $fields[] = 'sessions';
            $fields[] = 'months';
            $fields[] = 'city';
            $fields[] = 'state';
            $fields[] = 'country';
            $fields[] = 'location';
            // $fields[] = 'safarioperatorlist';
            $fields[] = 'operator';

            if (in_array(\Yii::$app->controller->action->uniqueId, ['park/default/view'])) {
                $fields[] = 'bufferzones';
                $fields[] = 'corezones';
                $fields[] = 'airport';
                $fields[] = 'vehicles';
                // $fields[] = 'airportdata';
                $fields[] = 'airportlist';
                $fields[] = 'safariVehicleslist';
                $fields[] =  'safariSessionslist';
                $fields[] =  'lockedMonthslist';
                $fields[] = 'railwaystation';
                $fields[] = 'railwaystationtwo';
                $fields[] = 'railwaystationlist';
                $fields[] = 'gallery';
                $fields[] = 'animals';
                // $fields[] = 'safarioperatorlist';
                $fields[] = 'operator';
                $fields[] = 'lockedMonths';
                $fields[] = 'sharedsafari';
            }

            $hold_fields = [
                'nearest_railway_station',
                'nearest_railway_station_distance',
                'nearest_airport',
                'nearest_airport_distance',
                'nearest_railway_station_two',
                'nearest_railway_station_distance_two',
                'nearest_railway_station_three',
                'nearest_railway_station_distance_three',
                'nearest_railway_station_four',
                'nearest_railway_station_distance_four',
                'nearest_railway_station_five',
                'nearest_railway_station_distance_five',
                'nearest_airport_two',
                'nearest_airport_distance_two',
                'nearest_airport_three',
                'nearest_airport_distance_three',
                'nearest_airport_four',
                'nearest_airport_distance_four',
                'nearest_airport_five',
                'nearest_airport_distance_five',
                'is_published',
                'master_location_id',
                'country_name',
                'state_name',
                'city_name',
                'status',
                'country_id',
                'state_id',
                'city_id',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];
        } else {
            $hold_fields = [
                'id',
                'show_in_filter',
                'park_type_id',
                'logo',
                'feature_image',
                'pincode',
                'nearest_railway_station_two',
                'nearest_railway_station_distance_two',
                'nearest_railway_station_three',
                'nearest_railway_station_distance_three',
                'nearest_railway_station_four',
                'nearest_railway_station_distance_four',
                'nearest_railway_station_five',
                'nearest_railway_station_distance_five',
                'nearest_airport_two',
                'nearest_airport_distance_two',
                'nearest_airport_three',
                'nearest_airport_distance_three',
                'nearest_airport_four',
                'nearest_airport_distance_four',
                'nearest_airport_five',
                'nearest_airport_distance_five',
                'about_title',
                'about_description',
                'module_title',
                'module_description',
                'florafauna',
                'animal_text',
                'month_note',
                'safri_cost_note',
                'is_published',
                'is_most_demanding',
                'is_shared_safari',
                'google_rating',
                'google_review_count',
                'total_view',
                'sequence',
                'animal_type_sequence',
                'short_description',
                'long_description',
                'meta_description',
                'meta_keywords',
                'master_location_id',
                'country_id',
                'state_id',
                'city_id',
                'status',
                'created_at',
                'updated_at',
                'created_by',
                'updated_by',
                'nearest_airport_distance',
                'nearest_railway_station_distance',

                'official_website',
                'country_name',
                'state_name',
                'city_name',
                'avg_safari_price_min',
                'avg_safari_price_max',
                'nearest_railway_station',
                'nearest_airport',
                'nearest_bus_station',
                'meta_title',
                'latitude',
                'longitude',
                'status',
                'country_id',
                'state_id',
                'city_id',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];
        }


        // $fields[] = 'safarioperatorlist';
        // $fields[] = 'rareanimals';

        // $fields[] = 'accomodations';
        // $fields[] = 'suggestions';
        // $fields[] = 'bonusexperience';


        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'city_id']);
    }
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'state_id']);
    }
    public function getCountry()
    {
        return $this->hasOne(MasterCountry::className(), ['id' => 'country_id']);
    }

    public function getLocation()
    {
        return $this->hasOne(MasterLocation::className(), ['id' => 'master_location_id']);
    }
    public function getAirport()
    {
        return $this->hasOne(MasterAirport::className(), ['id' => 'nearest_airport']);
    }

    public function getAirportdata($column_key = 'nearest_airport')
    {
        return $this->hasOne(MasterAirport::className(), ['id' => $column_key]);
    }


    public function getAirportlist()
    {
        $text = '';
        $first = $this->airportdata;
        $second = $this->getAirportdata('nearest_airport_two')->one();
        $third = $this->getAirportdata('nearest_airport_three')->one();
        $fourth = $this->getAirportdata('nearest_airport_four')->one();
        $fifth = $this->getAirportdata('nearest_airport_five')->one();

        if ($first) {
            if ($city = $first->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $first->name . $city_name . ', ';
        }

        if ($second) {
            if ($city = $second->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $second->name . $city_name . ', ';
        }

        if ($third) {
            if ($city = $third->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $third->name . $city_name . ', ';
        }

        if ($fourth) {
            if ($city = $fourth->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $fourth->name . $city_name . ', ';
        }

        if ($fifth) {
            if ($city = $fifth->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $fifth->name . $city_name . ', ';
        }
        return substr($text, 0, -2);
    }


    public function getRailwaystation()
    {
        return $this->hasOne(MasterRailwayStation::className(), ['id' => 'nearest_railway_station']);
    }

    public function getRailwaystationtwo()
    {
        return $this->hasOne(MasterRailwayStation::className(), ['id' => 'nearest_railway_station_two']);
    }

    public function getRailwaystationdata($column_key = 'nearest_railway_station')
    {
        return $this->hasOne(MasterRailwayStation::className(), ['id' => $column_key]);
    }


    public function getRailwaystationlist()
    {
        $text = '';
        $first = $this->railwaystationdata;
        $second = $this->getRailwaystationdata('nearest_railway_station_two')->one();
        $third = $this->getRailwaystationdata('nearest_railway_station_three')->one();
        $fourth = $this->getRailwaystationdata('nearest_railway_station_four')->one();
        $fifth = $this->getRailwaystationdata('nearest_railway_station_five')->one();

        if ($first) {
            $text .= $first->title . ', ';
        }

        if ($second) {
            $text .= $second->title . ', ';
        }

        if ($third) {
            $text .= $third->title . ', ';
        }

        if ($fourth) {
            $text .= $fourth->title . ', ';
        }

        if ($fifth) {
            $text .= $fifth->title . ', ';
        }
        return substr($text, 0, -2);
    }


    public function getGallery()
    {
        return $this->hasMany(SafariParkGallery::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_gallery.status' => 1]);
    }


    public function getSafarioperatorlist()
    {
        return $this->hasMany(SafariOperatorPark::className(), ['park_id' => 'id'])->andWhere(['safari_operator_park.status' => 1]);
    }

    public function getOperator()
    {
        return $this->hasMany(SafariOperator::className(), ['id' => 'safari_operator_id'])->via('safarioperatorlist')->andWhere(['safari_operator.status' => 1]);
    }

    public function getGalleryimag()
    {
        return $this->hasOne(SafariParkGallery::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_gallery.status' => 1]);
    }

    public function getSafariAnimals()
    {
        return $this->hasMany(SafariParkAnimal::className(), ['safari_park_id' => 'id'])->andWhere(['safari_parks_animal.status' => 1]);
    }

    public function getAnimals()
    {
        return $this->hasMany(MasterAnimal::className(), ['id' => 'master_animal_id'])->andWhere(['master_animal.status' => 1])->via('safariAnimals');
    }


    public function getRareanimals()
    {
        return $this->hasMany(SafariParkAnimal::className(), ['safari_park_id' => 'id'])->andWhere(['safari_parks_animal.status' => 1]);
    }

    public function getSafariSessions()
    {
        return $this->hasMany(SafariParkSession::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_session.status' => 1]);
    }


    public function getSafariSessionslist()
    {
        $sessions = $this->hasMany(MetaSafariSession::className(), ['id' => 'session_id'])->via('safariSessions')->all();
        $arr = [];
        foreach ($sessions as $session) {
            $arr[] = $session['title'];
        }
        return implode(", ", $arr);
    }


    public function getSessions()
    {
        return $this->hasMany(MetaSafariSession::className(), ['id' => 'session_id'])->via('safariSessions');
    }


    public function getSafariVehicles()
    {
        return $this->hasMany(SafariParkVehicle::className(), ['safari_park_id' => 'id'])->andWhere(['safari_parks_vehicle.status' => 1]);
    }

    public function getSafariVehicleslist()
    {
        $vehicles = $this->hasMany(MasterVehicle::className(), ['id' => 'vehicle_id'])->via('safariVehicles')->all();
        $arr = [];
        foreach ($vehicles as $vehicle) {
            $arr[] = $vehicle['vehicle_name'];
        }
        return implode(", ", $arr);
    }

    public function getVehicles()
    {
        return $this->hasMany(MasterVehicle::className(), ['id' => 'vehicle_id'])->via('safariVehicles');
    }



    public function getBufferzones()
    {
        return $this->hasMany(SafariParkZone::className(), ['safari_park_id' => 'id'])->andWhere(['master_zone_type_id' => 2, 'safari_park_zone.status' => 1]);
    }

    public function getCorezones()
    {
        return $this->hasMany(SafariParkZone::className(), ['safari_park_id' => 'id'])->andWhere(['master_zone_type_id' => 1, 'safari_park_zone.status' => 1]);
    }


    public function getSafariMonths()
    {
        return $this->hasMany(SafariParkMonth::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_month.status' => 1]);
    }

    public function getMonths()
    {
        return $this->hasMany(MasterMonth::className(), ['month' => 'month_id'])->via('safariMonths');
    }


    public function getSafariAccomodations()
    {
        return $this->hasMany(SafariParkAccomodation::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_accomodation.status' => 1]);
    }

    public function getAccomodations()
    {
        // return $this->hasMany(SafariParkAccomodation::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_accomodation.status' => 1]);

        return $this->hasMany(MetaAccommodation::className(), ['id' => 'master_accomodation_id'])->via(['safariAccomodations']);
    }

    // public function getSuggestions()
    // {
    //     return $this->hasMany(SafariSuggestions::className(), ['park_id' => 'id'])->andWhere(['safari_suggestions.status' => 1]);
    // }




    public function getBonusexperience()
    {
        return $this->hasMany(SafariParkBonusExperience::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_bonus_experience.status' => 1]);
    }

    public function getFeatureimagepath()
    {
        if ($this->feature_image != '') {
            return \Yii::$app->params['frontend_url_for_api'] . 'storage/safaripark/' . $this->id . '/' . $this->feature_image;
        }
    }

    public function getLogoimagepath()
    {
        if ($this->logo != '') {
            return \Yii::$app->params['frontend_url_for_api'] . 'storage/safaripark/' . $this->id . '/' . $this->logo;
        }
    }

    public function getSafariParkMonths()
    {

        return $this->hasMany(SafariParkMonth::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_month.status' => 1]);
    }

    public function getLockedMonthslist()
    {
        $closed_months = $this->hasMany(MasterMonth::className(), ['month' => 'month_id'])->via('safariParkMonths')->all();
        $arr = [];
        foreach ($closed_months as $month) {
            $arr[] = $month['month_name'];
        }
        return implode(", ", $arr);
    }

    public function getLockedMonths()
    {
        return $this->hasMany(MasterMonth::className(), ['month' => 'month_id'])->via('safariParkMonths');
    }


    public function getSharedsafari()
    {
        return $this->hasMany(ShareSafari::className(), ['park_id' => 'id'])->andWhere(['share_safari.status' => ShareSafari::STATUS_ACTIVE])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")]);
    }
}
