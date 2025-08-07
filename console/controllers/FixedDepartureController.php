<?php

namespace console\controllers;

use api\models\sharesafari\ShareSafari as ApiShareSafari;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariVersion;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class FixedDepartureController extends Controller
{
    public function actionStep1()
    {
        $db = Yii::$app->db;

        $transaction = $db->beginTransaction();
        try {
            // Drop copy tables if they exist
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_comment")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_day")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_faq")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_gallery")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_history")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_included")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_intrested")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_park")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_share_safari_comment_report")->execute();

            // Create structure from original tables
            $db->createCommand("CREATE TABLE backup_share_safari LIKE share_safari")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_comment LIKE share_safari_comment")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_day LIKE share_safari_day")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_faq LIKE share_safari_faq")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_gallery LIKE share_safari_gallery")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_history LIKE share_safari_history")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_included LIKE share_safari_included")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_intrested LIKE share_safari_intrested")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_park LIKE share_safari_park")->execute();
            $db->createCommand("CREATE TABLE backup_share_safari_comment_report LIKE share_safari_comment_report")->execute();

            // Insert data into new tables
            $db->createCommand("INSERT INTO backup_share_safari SELECT * FROM share_safari")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_comment SELECT * FROM share_safari_comment")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_day SELECT * FROM share_safari_day")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_faq SELECT * FROM share_safari_faq")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_gallery SELECT * FROM share_safari_gallery")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_history SELECT * FROM share_safari_history")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_included SELECT * FROM share_safari_included")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_intrested SELECT * FROM share_safari_intrested")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_park SELECT * FROM share_safari_park")->execute();
            $db->createCommand("INSERT INTO backup_share_safari_comment_report SELECT * FROM share_safari_comment_report")->execute();

            $transaction->commit();
            echo "Tables duplicated successfully.";
        } catch (\Exception $e) {
            $transaction->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function actionStep2()
    {
        $share_safaris = ShareSafari::find()->where(['type' => 1])->all();
        foreach ($share_safaris as $share_safari) {
            $share_safari->user_id = $share_safari->host_user_id;
            $share_safari->live_version = $share_safari->version;
            $share_safari->static_data_json = $this->prepareJson($share_safari->id);
            $share_safari->edit_status = 1;
            $share_safari->save(false);

            $share_safari_version_model = new ShareSafariVersion();

            $share_safari_version_model->share_safari_title = $share_safari->share_safari_title;
            $share_safari_version_model->share_safari_id = $share_safari->id;
            $share_safari_version_model->version = $share_safari->live_version;
            $share_safari_version_model->type = $share_safari->type;
            $share_safari_version_model->host_user_id = $share_safari->host_user_id;
            $share_safari_version_model->safari_operator_id = $share_safari->safari_operator_id;
            $share_safari_version_model->user_id = $share_safari->user_id;
            $share_safari_version_model->host_type = $share_safari->host_type;
            $share_safari_version_model->park_id = $share_safari->park_id;
            $share_safari_version_model->share_safari_agenda_id = $share_safari->share_safari_agenda_id;
            $share_safari_version_model->no_of_safari = $share_safari->no_of_safari;
            $share_safari_version_model->start_date = $share_safari->start_date;
            $share_safari_version_model->end_date = $share_safari->end_date;
            $share_safari_version_model->cut_off_date = $share_safari->cut_off_date;
            $share_safari_version_model->image_filepath = $share_safari->image_filepath;
            $share_safari_version_model->stay_category_id = $share_safari->stay_category_id;
            $share_safari_version_model->estimate_price_min = $share_safari->estimate_price_min;
            $share_safari_version_model->estimate_price_max = $share_safari->estimate_price_max;
            $share_safari_version_model->cost_per_person = $share_safari->cost_per_person;
            $share_safari_version_model->safari_plan = $share_safari->safari_plan;
            $share_safari_version_model->total_seat = $share_safari->total_seat;
            $share_safari_version_model->share_seat = $share_safari->share_seat;
            $share_safari_version_model->tour_duration = $share_safari->tour_duration;
            $share_safari_version_model->share_safari_inclusion = $share_safari->share_safari_inclusion;
            $share_safari_version_model->share_safari_exclusion = $share_safari->share_safari_exclusion;
            $share_safari_version_model->getting_there = $share_safari->getting_there;
            $share_safari_version_model->breakfast_included = $share_safari->breakfast_included;
            $share_safari_version_model->lunch_included = $share_safari->lunch_included;
            $share_safari_version_model->dinner_included = $share_safari->dinner_included;
            $share_safari_version_model->meal_not_included = $share_safari->meal_not_included;
            $share_safari_version_model->created_at = $share_safari->created_at;
            $share_safari_version_model->created_by = $share_safari->created_by;
            $share_safari_version_model->updated_at = $share_safari->updated_at;
            $share_safari_version_model->updated_by = $share_safari->updated_by;
            $share_safari_version_model->delete_reason_id = $share_safari->delete_reason_id;
            $share_safari_version_model->delete_reason = $share_safari->delete_reason;
            $share_safari_version_model->is_published_on_api = $share_safari->is_published_on_api;
            $share_safari_version_model->is_published_on_web = $share_safari->is_published_on_web;

            $share_safari_version_model->status = 1;
            $share_safari_version_model->save(false);
        }
    }


    public function actionStep3()
    {
        $share_safaris = ShareSafari::find()->where(['type' => 2])->all();
        foreach ($share_safaris as $safari) {
            $safari->status = -1;
            $safari->save(false);
        }
    }

    public function prepareJson($id)
    {
        $this->layout = \common\interfaces\NewStatusInterface::SHARE_SAFARI_API_LAYOUT_FULL;

        $share_safari = ApiShareSafari::find()->where(['id' => $id])->limit(1)->one();

        $json = [
            'share_safari' => [
                'share_safari_title' => $share_safari->share_safari_title,
                'slug' => $share_safari->slug,
                'no_of_safari' => $share_safari->no_of_safari,
                'start_date' => $share_safari->start_date,
                'end_date' => $share_safari->end_date,
                'cut_off_date' => $share_safari->cut_off_date,
                'total_seat' => $share_safari->total_seat,
                'share_seat' => $share_safari->share_seat,
                'types' => $share_safari->types,
                'organized_by_name' => $share_safari->organizedbyname,
                'organized_by_image' => $share_safari->organizedbyimage,
                'organized_slug' => $share_safari->organizedslug,
                'shared_image_path' => $share_safari->sharedimagepath,
                'seat_full_status' => $share_safari->seat_full_status,
                'park_title' => $share_safari->park_title,
                'park_slug' => $share_safari->park_slug,
                'cost_per_person' => $share_safari->cost_per_person,
                'breakfast_included' => $share_safari->breakfast_included,
                'lunch_included' => $share_safari->lunch_included,
                'dinner_included' => $share_safari->dinner_included,
                'meal_not_included' => $share_safari->meal_not_included,
                'meals_label' => $share_safari->meals_label,
                'share_safari_inclusion' => $share_safari->share_safari_inclusion,
                'share_safari_exclusion' => $share_safari->share_safari_exclusion,
                'getting_there' => $share_safari->getting_there,
                'safari_plan' => $share_safari->safari_plan,
                'share_safari_agenda' => $share_safari->share_safari_agenda,
                'stay_category_display' => $share_safari->stay_category_display,
                'stay_category_id' => $share_safari->stay_category_id,
                'parks' => ArrayHelper::toArray($share_safari->parks),
                'includeds' => ArrayHelper::toArray($share_safari->includeds),
                'share_safari_days' => ArrayHelper::toArray($share_safari->share_safari_days),
            ],
        ];

        return json_encode($json);
    }

    // public function actionStep3()
    // {
    //     $share_safaris = ShareSafari::find()->where(['type' => 2])->all();
    //     foreach ($share_safaris as $share_safari) {
    //         $share_safari->safari_operator_id = $share_safari->host_user_id;
    //         $share_safari->host_user_id = null;
    //         $share_safari->user_id = $share_safari->created_by;
    //         $share_safari->editable_version = 1;
    //         $share_safari->status = 0;
    //         $share_safari->save(false);

    //         $share_safari_version_model = new ShareSafariVersion();

    //         $share_safari_version_model->share_safari_title = $share_safari->share_safari_title;
    //         $share_safari_version_model->share_safari_id = $share_safari->id;
    //         $share_safari_version_model->version = 1;
    //         $share_safari_version_model->type = $share_safari->type;
    //         $share_safari_version_model->host_user_id = $share_safari->host_user_id;
    //         $share_safari_version_model->safari_operator_id = $share_safari->safari_operator_id;
    //         $share_safari_version_model->user_id = $share_safari->user_id;
    //         $share_safari_version_model->host_type = $share_safari->host_type;
    //         $share_safari_version_model->park_id = $share_safari->park_id;
    //         $share_safari_version_model->share_safari_agenda_id = $share_safari->share_safari_agenda_id;
    //         $share_safari_version_model->no_of_safari = $share_safari->no_of_safari;
    //         $share_safari_version_model->start_date = $share_safari->start_date;
    //         $share_safari_version_model->end_date = $share_safari->end_date;
    //         $share_safari_version_model->cut_off_date = $share_safari->cut_off_date;
    //         $share_safari_version_model->image_filepath = $share_safari->image_filepath;
    //         $share_safari_version_model->stay_category_id = $share_safari->stay_category_id;
    //         $share_safari_version_model->estimate_price_min = $share_safari->estimate_price_min;
    //         $share_safari_version_model->estimate_price_max = $share_safari->estimate_price_max;
    //         $share_safari_version_model->cost_per_person = $share_safari->cost_per_person;
    //         $share_safari_version_model->safari_plan = $share_safari->safari_plan;
    //         $share_safari_version_model->total_seat = $share_safari->total_seat;
    //         $share_safari_version_model->share_seat = $share_safari->share_seat;
    //         $share_safari_version_model->tour_duration = $share_safari->tour_duration;
    //         $share_safari_version_model->share_safari_inclusion = $share_safari->share_safari_inclusion;
    //         $share_safari_version_model->share_safari_exclusion = $share_safari->share_safari_exclusion;
    //         $share_safari_version_model->getting_there = $share_safari->getting_there;
    //         $share_safari_version_model->breakfast_included = $share_safari->breakfast_included;
    //         $share_safari_version_model->lunch_included = $share_safari->lunch_included;
    //         $share_safari_version_model->dinner_included = $share_safari->dinner_included;
    //         $share_safari_version_model->meal_not_included = $share_safari->meal_not_included;
    //         $share_safari_version_model->created_at = $share_safari->created_at;
    //         $share_safari_version_model->created_by = $share_safari->created_by;
    //         $share_safari_version_model->updated_at = $share_safari->updated_at;
    //         $share_safari_version_model->updated_by = $share_safari->updated_by;
    //         $share_safari_version_model->delete_reason_id = $share_safari->delete_reason_id;
    //         $share_safari_version_model->delete_reason = $share_safari->delete_reason;
    //         $share_safari_version_model->is_published_on_api = $share_safari->is_published_on_api;
    //         $share_safari_version_model->is_published_on_web = $share_safari->is_published_on_web;

    //         $share_safari_version_model->status = 3;
    //         $share_safari_version_model->save(false);
    //     }
    // }
}
