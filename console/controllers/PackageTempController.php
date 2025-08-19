<?php

namespace console\controllers;

use api\models\package\Package as ApiPackage;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use common\models\package\PackageVersion;
use common\models\partnergallery\PartnerGalleryVersion;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;


class PackageTempController extends Controller
{
    public function actionBackUp()
    {
        $db = Yii::$app->db;

        $transaction = $db->beginTransaction();
        try {
            // Drop copy tables if they exist
            $db->createCommand("DROP TABLE IF EXISTS backup_package")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_comment")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_comment_report")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_day")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_enquiry")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_faq")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_feature")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_gallery")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_included")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_quote")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_safari_park")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_package_version")->execute();

            // Create structure from original tables
            $db->createCommand("CREATE TABLE backup_package LIKE package")->execute();
            $db->createCommand("CREATE TABLE backup_package_comment LIKE package_comment")->execute();
            $db->createCommand("CREATE TABLE backup_package_comment_report LIKE package_comment_report")->execute();
            $db->createCommand("CREATE TABLE backup_package_day LIKE package_day")->execute();
            $db->createCommand("CREATE TABLE backup_package_enquiry LIKE package_enquiry")->execute();
            $db->createCommand("CREATE TABLE backup_package_faq LIKE package_faq")->execute();
            $db->createCommand("CREATE TABLE backup_package_feature LIKE package_feature")->execute();
            $db->createCommand("CREATE TABLE backup_package_gallery LIKE package_gallery")->execute();
            $db->createCommand("CREATE TABLE backup_package_included LIKE package_included")->execute();
            $db->createCommand("CREATE TABLE backup_package_quote LIKE package_quote")->execute();
            $db->createCommand("CREATE TABLE backup_package_safari_park LIKE package_safari_park")->execute();
            $db->createCommand("CREATE TABLE backup_package_version LIKE package_version")->execute();

            // Insert data into new tables
            $db->createCommand("INSERT INTO backup_package SELECT * FROM package")->execute();
            $db->createCommand("INSERT INTO backup_package_comment SELECT * FROM package_comment")->execute();
            $db->createCommand("INSERT INTO backup_package_comment_report SELECT * FROM package_comment_report")->execute();
            $db->createCommand("INSERT INTO backup_package_day SELECT * FROM package_day")->execute();
            $db->createCommand("INSERT INTO backup_package_enquiry SELECT * FROM package_enquiry")->execute();
            $db->createCommand("INSERT INTO backup_package_faq SELECT * FROM package_faq")->execute();
            $db->createCommand("INSERT INTO backup_package_feature SELECT * FROM package_feature")->execute();
            $db->createCommand("INSERT INTO backup_package_gallery SELECT * FROM package_gallery")->execute();
            $db->createCommand("INSERT INTO backup_package_included SELECT * FROM package_included")->execute();
            $db->createCommand("INSERT INTO backup_package_quote SELECT * FROM package_quote")->execute();
            $db->createCommand("INSERT INTO backup_package_safari_park SELECT * FROM package_safari_park")->execute();
            $db->createCommand("INSERT INTO backup_package_version SELECT * FROM package_version")->execute();

            $transaction->commit();
            echo "Tables duplicated successfully.";
        } catch (\Exception $e) {
            $transaction->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function actionStep1()
    {
        $package = Package::find()->all();
        foreach ($package as $pack) {
            $operator = SafariOperator::find()->where(['id' => $pack->safari_operator_id])->limit(1)->one();
            if ($operator) {
                $pack->user_id = $operator->user_id;
            }
            $pack->save(false);
        }

        $version = PackageVersion::find()->all();
        foreach ($version as $pack) {
            $operator = SafariOperator::find()->where(['id' => $pack->safari_operator_id])->limit(1)->one();
            if ($operator) {
                $pack->user_id = $operator->user_id;
            }
            $pack->save(false);
        }
    }

    public function actionStep1a()
    {
        $packages = Package::find()
            ->all();

        foreach ($packages as $pack) {
            if ($pack->partner_gallery_id) {
                $lastVersion = PartnerGalleryVersion::find()
                    ->where(['partner_gallery_id' => $pack->partner_gallery_id])
                    ->orderBy(['version' => SORT_DESC])
                    ->one();
                if ($lastVersion) {
                    $pack->gallery_version = $lastVersion->version;
                } else {
                    $pack->gallery_version = 1;
                }
                $pack->save(false);
            }
        }
    }

    public function actionStep2a()
    {
        $packages = PackageVersion::find()
            ->all();

        foreach ($packages as $pack) {
            if ($pack->partner_gallery_id) {
                $lastVersion = PartnerGalleryVersion::find()
                    ->where(['partner_gallery_id' => $pack->partner_gallery_id])
                    ->orderBy(['version' => SORT_DESC])
                    ->one();
                if ($lastVersion) {
                    $pack->gallery_version = $lastVersion->version;
                } else {
                    $pack->gallery_version = 1;
                }
                $pack->save(false);
            }
        }
    }


    public function actionStep2()
    {

        $packages = Package::find()
            ->where(['status' => 1])
            ->andWhere(['>=', 'cost_per_person', 1000])
            ->andWhere(['IS NOT', 'live_version', null])
            ->all();

        $keepIds = [];

        foreach ($packages as $pack) {
            $operator = SafariOperator::find()->where(['id' => $pack->safari_operator_id])->limit(1)->one();
            if ($operator) {
                if ($operator->status == 1) {
                    $keepIds[] = $pack->id;
                    $pack->edit_status = 0;
                    $pack->pending_status = 0;
                    $pack->editable_version = null;
                    $pack->pending_for_approval_version = null;
                    $pack->static_json = $this->prepareJson($pack->id);
                    $pack->save(false);
                }
            }
        }

        if (!empty($keepIds)) {
            $otherPackages = Package::find()
                ->where(['not in', 'id', $keepIds])
                ->all();

            foreach ($otherPackages as $other) {
                $other->status = -1;
                $other->save(false);
            }
        }
    }

    public function prepareJson($id)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PACKAGE_API_LAYOUT_FULL;
        $package = ApiPackage::find()->where(['id' => $id])->limit(1)->one();


        $json = [
            'package' => [
                'package_display_name' => $package->package_display_name,
                'package_name' => $package->package_name,
                'package_slug' => $package->package_slug,
                'primary_park' => $package->primary_park,
                'primary_park_slug' => $package->primary_park_slug,
                'no_of_day' => $package->no_of_day,
                'no_of_night' => $package->no_of_night,
                'no_of_safari' => $package->no_of_safari,
                'cost_per_person' => (int) ceil($package->cost_per_person),
                'cost_per_two_person' => (int) ceil($package->cost_per_two_person),
                'price_after_discount' => (int) ceil($package->price_after_discount),

                'package_description' => $package->package_description,
                'image_path' => $package->image_path,
                'image_banner_path' => $package->image_banner_path,
                'package_day_night_labels' => $package->package_day_night_labels,
                'pick_and_drop' => $package->pick_and_drop,
                'pick_and_drop_display' => $package->pick_and_drop_display,
                'stay_category_id' => $package->stay_category_id,
                'stay_category_display' => $package->stay_category_display,
                'meals_listing' => $package->meals_listing,
                'breakfast_included' => (bool) $package->breakfast_included,
                'lunch_included' => (bool) $package->lunch_included,
                'dinner_included' => (bool) $package->dinner_included,
                'meal_not_included' => (bool) $package->meal_not_included,
                'start_location' => $package->start_location,
                'end_location' => $package->end_location,
                'start_date' => $package->start_date,
                'end_date' => $package->end_date,
                'package_itinerary_overview' => $package->package_itinerary_overview,
                'package_inclusion' => $package->package_inclusion,
                'package_exclusion' => $package->package_exclusion,
                'getting_there' => $package->getting_there,
                'meals' => $package->meals,
                'meals_label' => $package->meals_label,
                'type' => $package->type,
                'master_vehicle_id' => $package->master_vehicle_id,
                'safari_type' => $package->safari_type,
                'gst_percentage' => $package->gst_percentage,
                'package_agenda_id' => $package->package_agenda_id,
                'max_booking_date' => $package->max_booking_date,

                'package_park' => ArrayHelper::toArray($package->package_park),
                'master_package_with_included' => ArrayHelper::toArray($package->master_package_with_included),
                'package_days' => ArrayHelper::toArray($package->package_days),
                'faqs' => ArrayHelper::toArray($package->faqs),
                'package_features_name' => ArrayHelper::toArray($package->package_features_name),

                'partner_gallery_id' => $package->partner_gallery_id,
                'gallery_json' => $package->gallery_json,
                'gallery_version' => $package->gallery_version
            ],
        ];

        return json_encode($json);
    }
}
