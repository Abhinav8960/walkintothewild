<?php

namespace console\controllers;

use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariVersion;
use Yii;
use yii\console\Controller;

class FixedDepartureController extends Controller
{
    public function actionStep2()
    {
        $share_safaris = ShareSafari::find()->where(['type' => 1])->all();
        foreach ($share_safaris as $share_safari) {
            $share_safari->user_id = $share_safari->host_user_id;
            $share_safari->live_version = 1;
            $share_safari->save(false);

            $share_safari_version_model = new ShareSafariVersion();

            $share_safari_version_model->share_safari_title = $share_safari->share_safari_title;
            $share_safari_version_model->share_safari_id = $share_safari->id;
            $share_safari_version_model->version = 1;
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
        foreach ($share_safaris as $share_safari) {
            $share_safari->safari_operator_id = $share_safari->host_user_id;
            $share_safari->host_user_id = null;
            $share_safari->user_id = $share_safari->created_by;
            $share_safari->editable_version = 1;
            $share_safari->status = 0;
            $share_safari->save(false);

            $share_safari_version_model = new ShareSafariVersion();

            $share_safari_version_model->share_safari_title = $share_safari->share_safari_title;
            $share_safari_version_model->share_safari_id = $share_safari->id;
            $share_safari_version_model->version = 1;
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

            $share_safari_version_model->status = 3;
            $share_safari_version_model->save(false);
        }
    }
}
