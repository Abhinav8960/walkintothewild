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
use api\models\package\Package;
use api\models\package\PackageSafariPark;
use api\models\sharesafari\ShareSafari;
use api\models\suggestions\SafariSuggestions;
use api\models\UserExperience;
use common\models\park\SafariParkMonth;

class SafariPark extends \common\models\park\SafariPark
{

    public function fields()
    {
        // $hold_fields = parent::fields();
        $fields = ['id', 'title', 'slug', 'featureimagepath', 'avg_safari_price_min', 'avg_safari_price_max', 'featureimagepath', 'city', 'state', 'location'];

        if (in_array(\Yii::$app->controller->layout, [SELF::PARK_API_LAYOUT_WITH_TOP_OPERATORS])) {
            $fields[] = 'top_operators';

        }

        if (in_array(\Yii::$app->controller->layout, [SELF::PARK_API_LAYOUT_FOR_FILTER_PARK])) {
            $fields = ['title', 'slug'];
        }

        if (in_array(\Yii::$app->controller->layout, [SELF::PARK_API_LAYOUT_FULL])) {
            $fields[] = 'latitude';
            $fields[] = 'longitude';
            $fields[] = 'official_website';
            // $fields[] = 'short_description';
            $fields[] = 'country';
            $fields[] = 'pincode';
            $fields[] = 'about_title';
            $fields[] = 'about_description';
            $fields[] = 'module_title';
            $fields[] = 'module_description';
            $fields[] = 'florafauna';
            $fields[] = 'animal_text';
            // $fields[] = 'animal_type_sequence';
            // $fields[] = 'safri_cost_note';
            // $fields[] = 'is_most_demanding';
            // $fields[] = 'is_shared_safari';
            // $fields[] = 'logo';
            $fields[] = 'long_description';
            $fields[] = 'months';
            $fields[] = 'bufferzones';
            $fields[] = 'corezones';
            $fields[] = 'nearest_bus_station';
            $fields[] = 'airport';
            $fields[] = 'airportlist';
            $fields[] = 'vehicles';
            $fields[] = 'safariVehicleslist';
            $fields[] = 'sessions';
            $fields[] = 'safariSessionslist';
            $fields[] = 'lockedMonthslist';
            // $fields[] = 'railwaystation';
            // $fields[] = 'railwaystationtwo';
            $fields[] = 'railwaystationlist';
            $fields[] = 'lockedMonths';
            // $fields[] = 'animals';
            $fields[] = 'averagerating';
            // $fields[] = 'countreview';
            $fields[] = 'google_rating';
            $fields[] = 'google_review_count';
            // $fields[] = 'total_view';
            // $fields[] = 'gallery';
            $fields[] = 'urls';
        }


        // return array_diff($fields);
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
        $columns = ['nearest_airport', 'nearest_airport_two', 'nearest_airport_three', 'nearest_airport_four', 'nearest_airport_five'];
        foreach ($columns as $column) {
            $city_name = '';
            if ($airport = $this->getAirportdata($column)->one()) {
                if ($city = $airport->city) {
                    $city_name = ' (' . $city->city_name . ')';
                }
                $text .= $airport->name . $city_name . ', ';
            }
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
        $columns = ['nearest_railway_station', 'nearest_railway_station_two', 'nearest_railway_station_three', 'nearest_railway_station_four', 'nearest_railway_station_five'];
        foreach($columns as $column){
            if ($railwaystation = $this->getRailwaystationdata($column)->one()) {
                $text .= $railwaystation->title . ', ';
            }
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

    public function getTop_operators()
    {
        return $this->getOperator()->limit(5);
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
        $sessions = $this->getSessions()->all();
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
        $vehicles = $this->getVehicles()->all();
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


    // public function getSafariAccomodations()
    // {
    //     return $this->hasMany(SafariParkAccomodation::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_accomodation.status' => 1]);
    // }

    public function getAccomodations()
    {
        // return $this->hasMany(SafariParkAccomodation::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_accomodation.status' => 1]);
        return $this->hasMany(SafariParkAccomodation::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_accomodation.status' => 1]);

        // return $this->hasMany(MetaAccommodation::className(), ['id' => 'master_accomodation_id'])->via(['safariAccomodations']);
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


    public function getPackagepark()
    {
        return $this->hasMany(PackageSafariPark::className(), ['park_id' => 'id'])->andWhere(['package_safari_park.status' => 1]);
    }

    public function getPackage()
    {
        return $this->hasMany(Package::className(), ['id' => 'package_id'])->andwhere(['package.status' => 1])->via('packagepark');
    }

    public function getAveragerating()
    {
        $avg = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $this->id])->average('rating');
        return round($avg, 1);
    }

    public function getCountreview()
    {
        return SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $this->id])->count();
    }

    public function getUrls()
    {
        return [
            'operators' =>  Yii::$app->params['api_url'] . '/park/' . $this->slug . '/park-operator',
            'sharedsafari' => Yii::$app->params['api_url'] . '/park/' . $this->slug . '/park-shared-safari',
            'package' => Yii::$app->params['api_url'] . '/park/' . $this->slug . '/park-package',
            'review' => Yii::$app->params['api_url'] . '/park/' . $this->slug . '/reviewlist?sort_by=highest',
        ];
    }
}
