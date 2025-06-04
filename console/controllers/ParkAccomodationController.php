<?php

namespace console\controllers;

use common\models\package\Package;
use common\models\package\PackageVersion;
use common\models\park\SafariParkAccomodation;
use yii\console\Controller;



/**
 * ParkAccomodationController
 */
class ParkAccomodationController extends Controller
{

    public function actionChangeValue()
    {
        $safari_park_accomodation_model = SafariParkAccomodation::find()->all();
        foreach($safari_park_accomodation_model as $accomodation)
        {
            if($accomodation->meta_stay_category_id == 1)
            {
                $accomodation->meta_stay_category_id = 5;
            }
            else if($accomodation->meta_stay_category_id == 2)
            {
                $accomodation->meta_stay_category_id = 7;
            }
            $accomodation->save(false);
        }
        echo "Done";
    }

    public function actionUpdateMaxbookingdate()
    {
        $package_version = PackageVersion::find()->all();
        foreach($package_version as $version)
        {
            $version->max_booking_date = '2026-03-31';
            $version->save(false);
        }

        $packages = Package::find()->all();
        foreach($packages as $p)
        {
            $p->max_booking_date = '2026-03-31';
            $p->save(false);
        }
        echo "Done";
    }
}
