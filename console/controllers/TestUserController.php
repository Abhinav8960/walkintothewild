<?php

namespace console\controllers;

use common\models\Auth;
use common\models\chat\Chat;
use common\models\operator\SafariOperator;
use common\models\User;
use Faker\Factory;
use Yii;
use yii\console\Controller;

/**
 * TestUserController implements the CRUD actions for FrontendRequestLog model.
 */
class TestUserController extends Controller
{

    public function actionGenerateSocialUsers($count = 5)
    {
        $faker = Factory::create();

        for ($i = 1; $i <= $count; $i++) {
            $user = new User();
            if ($i < 3) {
                $user->username = "op" . $i . "@gmail.com";
                $user->name = "op" . $i;
                $user->email = "op" . $i . "@gmail.com";
                $user->is_safari_operator = 1;
            } else {
                $user->username = "u" . $i . "@gmail.com";
                $user->name = "u" . $i;
                $user->email = "u" . $i . "@gmail.com";
            }


            // $user->mobile_no = $faker->unique()->phoneNumber;
            $user->mobile_no = rand(8888888888, 9999999999);
            $user->token_key = Yii::$app->security->generateRandomString();
            $user->verification_token = Yii::$app->security->generateRandomString();
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->password_hash = Yii::$app->security->generatePasswordHash('password123');
            $user->google_source_id = (int)('1' . '' . $i);
            $user->can_login = 1;
            $user->status = User::STATUS_ACTIVE;
            $user->save(false);
            $auth = new Auth([
                'user_id' => $user->id,
                'source' => 'google',
                'source_id' => $user->google_source_id,
            ]);
            $auth->save(false);
            if ($i < 3) {
                $this->makeoperator($user);
            }
        }

        return true;
    }

    private function generateGoogleSourceId()
    {
        $digits = '';
        for ($i = 0; $i < 21; $i++) {
            $digits .= mt_rand($i === 0 ? 1 : 0, 9);
        }
        return $digits;
    }

    public function makeoperator($user)
    {
        $safari_operator_model = new SafariOperator();
        $safari_operator_model->operator_name =  $user->name . " operator";
        $safari_operator_model->operator_email = $user->email;
        $safari_operator_model->operator_phone_no = $user->mobile_no;
        $safari_operator_model->user_id = $user->id;
        $safari_operator_model->is_approved = 1;
        $safari_operator_model->safari_operator_request_id = NULL;
        $safari_operator_model->category_id = 1;
        $safari_operator_model->business_name =  $user->name . ' operator business';
        $safari_operator_model->register_comapany_name =  $user->name . ' register comapany name';
        $safari_operator_model->is_highlighted = 0;
        $safari_operator_model->google_rating = 0;
        $safari_operator_model->google_review_count = 0;
        $safari_operator_model->facebook_url = null;
        $safari_operator_model->instagram_url = null;
        $safari_operator_model->youtube_link = null;
        $safari_operator_model->phone_no = $user->mobile_no;
        $safari_operator_model->email = $user->email;
        $safari_operator_model->website = null;
        $safari_operator_model->is_register_company = 0;
        $safari_operator_model->has_a_website = 0;
        $safari_operator_model->has_cancellation_policy = 0;
        $safari_operator_model->wildlife_photographer = 0;
        $safari_operator_model->wildlife_influencer = 0;
        $safari_operator_model->is_offer_premium_budget = 1;
        $safari_operator_model->is_offer_standard_budget = 0;
        $safari_operator_model->is_offer_economical_budget = 0;
        $safari_operator_model->is_wildlife_trekking = 0;
        $safari_operator_model->is_wildlife_non_safari_drive = 0;
        $safari_operator_model->is_bird_watching = 0;
        $safari_operator_model->is_camping = 0;
        $safari_operator_model->starting_price = 2000;
        $safari_operator_model->is_approved = 1;
        if ($safari_operator_model->save(false)) {
            return true;
        }
    }

    public function actionGenerateUserHandle()
    {
        $users = User::find()->where(['user_handle' => NULL])->all();
        foreach ($users as $user) {
            $baseHandle = strtolower(str_replace(' ', '_', $user->name));
            $uniqueHandle = $baseHandle;

            // Ensure the handle is unique
            $counter = 1;
            while (User::find()->where(['user_handle' => $uniqueHandle])->exists()) {
                $uniqueHandle = $baseHandle . '_' . $counter;
                $counter++;
            }

            $user->user_handle = $uniqueHandle;
            if ($user->save(false)) {
                echo "Handle for user {$user->id} generated: {$user->user_handle}\n";
            } else {
                echo "Failed to save handle for user {$user->id}\n";
            }
        }
        return true;
    }

    
}
