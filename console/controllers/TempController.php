<?php

namespace console\controllers;

use api\models\package\Package as ApiPackage;
use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\chat\ChatMessageHistory;
use common\models\cms\banner\Banner;
use common\models\cms\frontendbanner\FrontendBanner;
use common\models\feeds\Feeds;
use common\models\leads\Lead;
use common\models\master\animal\MasterAnimal;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\master\vehicle\MasterVehicle;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use common\models\package\PackageVersion;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGalleryVersion;
use common\models\partnergalleryimage\PartnerGalleryImage;
use common\models\postscomment\UserPostComment;
use common\models\postscomment\UserPostLike;
use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use common\models\sighting\SightingLike;
use common\models\UserPosts;
use common\models\UserSession;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

/**
 * TempController implements the CRUD actions for FrontendRequestLog model.
 */
class TempController extends Controller
{


    public function actionLeadDisable()
    {
        $leads = Lead::find()->where(['<', 'created_at', time()])->all();
        foreach ($leads as $lead) {
            $chat = Chat::find()->where(['lead_id' => $lead->id])->one();
            if (!empty($chat)) {
                $chat_messages = ChatMessage::find()->where(['chat_id' => $chat->id])->count();
                if ($chat_messages < 2) {
                    $lead->status = 0;
                } else {
                    $lead->is_chat_started = 1;
                }
                $lead->save(false);
            }
        }
        echo "\n";
        echo "Done";
    }

    public function actionUpdatePostCommentCount()
    {
        $user_posts = UserPosts::find()->all();
        foreach ($user_posts as $post) {
            $comment_count = UserPostComment::find()->where(['user_posts_id' => $post->id])->andWhere(['status' => 1])->count();
            if ($comment_count > 0) {
                $post->comment_count = $comment_count;
                $post->save(false);
            }
        }
        echo "Done";
    }

    public function actionUpdatePostLikeCount()
    {
        $user_posts = UserPosts::find()->all();
        foreach ($user_posts as $post) {
            $like_count = UserPostLike::find()->where(['user_post_id' => $post->id])->andWhere(['status' => 1])->count();
            if ($like_count > 0) {
                $post->like_count = $like_count;
                $post->save(false);
            }
        }
        echo "Done";
    }

    public function actionSightingCommentCount()
    {
        $sightings = Sighting::find()->all();
        foreach ($sightings as $sighting) {
            $comment_count = SightingComment::find()->where(['sighting_id' => $sighting->id])->andWhere(['status' => 1])->count();
            if ($comment_count > 0) {
                $sighting->comment_count = $comment_count;
                $sighting->save(false);
            }
        }
        echo "Done";
    }

    public function actionSightingLikeCount()
    {
        $sightings = Sighting::find()->all();
        foreach ($sightings as $sighting) {
            $like_count = SightingLike::find()->where(['sighting_id' => $sighting->id])->andWhere(['status' => 1])->count();
            if ($like_count > 0) {
                $sighting->like_count = $like_count;
                $sighting->save(false);
            }
        }
        echo "Done";
    }

    public function actionChatSenderId()
    {
        $chats = Chat::find()
            ->where(['sender_id' => null])
            ->all();
        foreach ($chats as $chat) {
            $chatmessage = ChatMessage::find()
                ->where(['chat_id' => $chat->id])
                ->andWhere(['status' => 1])
                ->orderBy(['created_at' => SORT_DESC])
                ->one();
            $chat->sender_id = $chatmessage->created_by == $chat->user_id ? $chat->user_id : $chat->recipient_user_id;
            if ($chat->save(false)) {
                echo "Chat ID {$chat->id} updated with sender_id: {$chat->sender_id}\n";
            } else {
                echo "Failed to update chat ID {$chat->id}\n";
            }
        }

        return true;
    }

    public function actionBannerImage()
    {
        $banner_model = Banner::find()->all();
        foreach ($banner_model as $model) {
            if ($model->image != null) {
                $model->image_path = 'banner/2506/' . $model->image;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionBannerCopy()
    {
        $banner_model = Banner::find()->all();

        foreach ($banner_model as $model) {
            if (!empty($model->image)) {
                $sourcePath = 'banner/' . $model->id . '/' . $model->image;
                $extension = pathinfo($model->image, PATHINFO_EXTENSION);

                $fileName = $model->id . '_banner_' . time() . '.' . $extension;

                $destinationPath = 'banner/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->image = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionFrontendBannerImage()
    {
        $banner_model = FrontendBanner::find()->all();
        foreach ($banner_model as $model) {
            if ($model->frontend_banner != null) {
                $model->frontend_banner_path = 'frontend_banner/2506/' . $model->frontend_banner;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionFrontendBannerCopy()
    {
        $banner_model = FrontendBanner::find()->all();

        foreach ($banner_model as $model) {
            if (!empty($model->frontend_banner)) {
                $sourcePath = 'frontend_banner/' . $model->id . '/' . $model->frontend_banner;
                $extension = pathinfo($model->frontend_banner, PATHINFO_EXTENSION);

                $fileName = $model->id . '_frontend_banner_' . time() . '.' . $extension;

                $destinationPath = 'frontend_banner/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->frontend_banner = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionMasterVehicle()
    {
        $master_model = MasterVehicle::find()->all();
        foreach ($master_model as $model) {
            if ($model->icon != null) {
                $model->icon_path = 'icon/2506/' . $model->icon;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionMasterVehicleCopy()
    {
        $master_model = MasterVehicle::find()->all();

        foreach ($master_model as $model) {
            if (!empty($model->icon)) {
                $sourcePath = 'icon/' . $model->id . '/' . $model->icon;
                $extension = pathinfo($model->icon, PATHINFO_EXTENSION);

                $fileName = $model->id . '_icon_' . time() . '.' . $extension;

                $destinationPath = 'icon/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->icon = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionRareAnimal()
    {
        $master_model = MasterAnimal::find()->all();
        foreach ($master_model as $model) {
            if ($model->banner != null) {
                $model->banner_path = 'rareanimal/2506/' . $model->banner;
                $model->save(false);
            }

            if ($model->feature_image != null) {
                $model->feature_image_path = 'rareanimal/2506/' . $model->feature_image;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionRareAnimalCopy()
    {
        $master_model = MasterAnimal::find()->all();

        foreach ($master_model as $model) {
            if (!empty($model->banner)) {
                $sourcePath = 'rareanimal/' . $model->id . '/' . $model->banner;
                $extension = pathinfo($model->banner, PATHINFO_EXTENSION);

                $fileName = $model->id . '_rareanimal_banner_' . time() . '.' . $extension;

                $destinationPath = 'rareanimal/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->banner = $fileName;
                    $model->save(false);
                }
            }
            if (!empty($model->feature_image)) {
                $sourcePath = 'rareanimal/' . $model->id . '/' . $model->feature_image;
                $extension = pathinfo($model->feature_image, PATHINFO_EXTENSION);

                $fileName = $model->id . '_rareanimal_feature_image_' . time() . '.' . $extension;

                $destinationPath = 'rareanimal/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->feature_image = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionQuoteUserNotify()
    {
        $count = 0;
        $leads = Lead::find()->where(['status' => 1])->all();
        foreach ($leads as $lead) {
            $chats = Chat::find()->where(['status' => 1, 'lead_id' => $lead->id, 'chat_type' => 2])->all();
            foreach ($chats as $chat) {
                // echo "Chat ID: {$chat->id}\n";
                // $chatmessage = ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->andWhere(['>', 'quotation_id', 0])->orderBy(['id' => SORT_DESC])->one();
                // $chatmessage = ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id, 'is_quotation_message' => 1])->orderBy(['id' => SORT_DESC])->one();
                $chatmessage = ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderBy(['id' => SORT_DESC])->one();
                if (!empty($chatmessage)) {
                    // echo "Chat Message ID: {$chatmessage->id}\n";
                    $userMessagesAfterQuotation = ChatMessage::find()
                        ->where(['chat_id' => $chatmessage->chat_id, 'created_by' => $chat->recipient_user_id])
                        ->andWhere(['status' => 1])
                        ->andWhere(['>', 'id', $chatmessage->id])
                        ->count();

                    if ($chatmessage->created_by == $chat->recipient_user_id && $userMessagesAfterQuotation == 0) {
                        echo "No user messages after quotation for Chat ID: {$chat->id}\n";
                        $count++;
                        $master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::CHAT_MESSAGE_RECEIVED_REGISTRATION_TEMPLATE, 'status' => 1])->limit(1)->one();
                        $title = \Yii::$app->engine->render($master_notification_template->title, ['sender' => $chat->sender->name]);
                        $body = \Yii::$app->engine->render($master_notification_template->message, ['message' => strip_tags($chat->last_message)]);
                        $data = MasterNotificationTemplate::prepareSendData(
                            $title,
                            $body,
                            [
                                'objective' => Chat::OBJECTIVE_QUOTE,
                                'chat_hash' => $chat->chat_hash,
                                'sender_name' => $chat->sender->name,
                                'user_handle' => $chat->sender->user_handle,
                                'lead_id' => $chat->lead_id,
                                'can_call' => $chat->callpossible()
                            ]
                        );
                        $receiver_id = $chat->user_id;
                        $token = $this->firebaseTokens($receiver_id);
                        if ($token) {
                            print_r([
                                "count" => $count,
                                "chat" => $chat->id,
                                "chat_message" => $chatmessage->id,
                                "receiver_id" => $receiver_id,
                                "tokens" => $token,
                                "title" => $title,
                                "body" => $body,
                            ]);
                            // \Yii::$app->firebase->sendMulticastNotification($title, $body, $imageUrl = NULL, $token, $data, $topic = NULL, $condition = NULL);
                        }
                    }
                }
            }
        }
        echo "done";
    }



    private function firebaseTokens($userId)
    {
        $uds =  UserSession::find()
            // ->where(['user_id1' => $userId, 'app_name' => 'Api'])
            ->where(['user_id' => $userId])
            ->andWhere(['not', ['firebase_token' => null]])
            ->andWhere(['!=', 'firebase_token', ''])
            ->andWhere(['is_firebase_token_active' => 1])
            ->all();
        $tokens = [];
        foreach ($uds as $ud) {
            $tokens[] = $ud->firebase_token;
        }
        $array = array_unique($tokens);

        return $array;
    }

    public function actionMakeCallOnChat()
    {
        $url = \Yii::$app->params['airphone_api_host_url'] . '/api/c2c';
        $options = [
            'vnm' => \Yii::$app->params['airphone_api_vnm'],
            'agent' => "9650901148",
            // 'caller' => "8890534746",
            'caller' => "9958858979", // Apurva Sir
            'token' => \Yii::$app->params['airphone_api_token'],
            'reqId' => "dfgh"
        ];
        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->setUrl($url)
            ->setData($options) // Use setData for form parameters
            ->send();
        if (!$response->isOk) {
            \Yii::error('Call failed: ' . $response->content, __METHOD__);
            return false;
        }
        $json_contents = json_encode($response->content);
        $arr_contents = json_decode($response->content, true);

        // print_r([$response->content, $options]);
        // die();
        // if (is_array($arr_contents) && !empty($arr_contents)) {
        //     if (isset($arr_contents['status']) && strtolower($arr_contents['status']) == 'success') {
        //         $this->call_model->unique_id = $arr_contents['unique_id'];
        //         $this->call_model->status = CallLog::STATUS_SUCCESS;
        //     }
        // }
        // $this->call_model->call_request_status = $arr_contents['status'];
        // $this->call_model->call_request_message = $arr_contents['message'];
        // $this->call_model->save(false);
        // return $this->call_model->status;

        die('kjjkj');
        // Call the callNow method
        $result = $callingService->callNow();

        return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Call initiated.']);
    }

    public function actionApprovedGallery()
    {
        $partner_galleries = PartnerGallery::find()
            ->where(['IS NOT', 'live_images', null])
            ->all();

        foreach ($partner_galleries as $gallery) {
            $gallery_images_count = PartnerGalleryImage::find()
                ->where(['partner_gallery_id' => $gallery->id, 'status' => PartnerGalleryImage::STATUS_ACTIVE])
                ->count();

            $live_gallery_images_count = 0;
            if (!empty($gallery->live_images)) {
                $c_arr = json_decode($gallery->live_images, true);
                $live_gallery_images_count = $c_arr['image_count'] ?? 0;
            }

            $version = new PartnerGalleryVersion();
            $version->partner_gallery_id = $gallery->id;
            $version->version = 1;
            $version->safari_operator_id = $gallery->safari_operator_id;
            $version->park_id = $gallery->park_id;
            $version->title = $gallery->title;
            $version->slug = $gallery->slug;
            $version->remark = $gallery->remark;
            $version->can_send_for_approval = $gallery->can_send_for_approval;
            $version->live_images = $gallery->live_images;
            $version->in_draft = $gallery->in_draft;
            $version->send_for_approval = $gallery->send_for_approval;
            $version->is_approved = $gallery->is_approved;
            $version->is_live = 1;
            $version->status = $gallery->status;
            $version->gallery_images_count = $gallery_images_count;
            $version->live_gallery_images_count = $live_gallery_images_count;
            $version->save(false);


            $gallery->in_draft = 1;
            $gallery->send_for_approval = 0;
            $gallery->is_approved = 0;
            $gallery->is_live = 1;
            $gallery->gallery_images_count = $gallery_images_count;
            $gallery->live_gallery_images_count = $live_gallery_images_count;
            $gallery->save(false);
        }

        echo "Done";
    }

    public function actionUpdateVersion()
    {
        $chat_messages = ChatMessage::find()->where(['IS NOT', 'gallery', null])->all();

        foreach ($chat_messages as $chat) {
            $json = json_decode($chat->gallery, true);

            if (isset($json['images'][0]['id'])) {
                $image_id = $json['images'][0]['id'];

                $partner_gallery_image = PartnerGalleryImage::find()
                    ->where(['id' => $image_id])
                    ->limit(1)
                    ->one();

                if ($partner_gallery_image) {
                    $version = PartnerGalleryVersion::find()
                        ->where([
                            'partner_gallery_id' => $partner_gallery_image->partner_gallery_id,
                            'is_live' => 1,
                        ])
                        ->limit(1)
                        ->one();

                    if ($version) {
                        $chat->partner_gallery_version_id = $version->id;
                        $chat->save(false);
                    }
                }
            }
        }

        echo 'Done';
    }


    public function actionUpdateVersionHistory()
    {
        $chat_messages = ChatMessageHistory::find()->where(['IS NOT', 'gallery', null])->all();

        foreach ($chat_messages as $chat) {
            $json = json_decode($chat->gallery, true);

            if (isset($json['images'][0]['id'])) {
                $image_id = $json['images'][0]['id'];

                $partner_gallery_image = PartnerGalleryImage::find()
                    ->where(['id' => $image_id])
                    ->limit(1)
                    ->one();

                if ($partner_gallery_image) {
                    $version = PartnerGalleryVersion::find()
                        ->where([
                            'partner_gallery_id' => $partner_gallery_image->partner_gallery_id,
                            'is_live' => 1,
                        ])
                        ->limit(1)
                        ->one();

                    if ($version) {
                        $chat->partner_gallery_version_id = $version->id;
                        $chat->save(false);
                    }
                }
            }
        }

        echo 'Done';
    }


    public function actionUpdateGalleryUserId()
    {
        $galleries = PartnerGallery::find()->all();
        foreach ($galleries as $gallery) {
            $gallery->user_id = $gallery->created_by;
            $gallery->save(false);
        }

        $versions = PartnerGalleryVersion::find()->all();

        foreach ($versions as $version) {
            $operator = SafariOperator::find()->where(['id' => $version->safari_operator_id])->limit(1)->one();
            $version->user_id = $operator->user_id;
            $version->save(false);
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


    public function actionStep2()
    {

        $packages = Package::find()
            ->where(['status' => 1])
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

                'package_description' => $package->package_description,
                'image_path' => $package->image_path,
                'image_banner_path' => $package->image_banner_path,
                'package_day_night_labels' => $package->package_day_night_labels,
                'pick_and_drop' => $package->pick_and_drop,
                'pick_and_drop_display' => $package->pick_and_drop_display,
                'stay_category_id' => $package->stay_category_id,
                'stay_category_display' => $package->stay_category_display,
                'meals_listing' => $package->meals_listing,
                'breakfast_included' => $package->breakfast_included,
                'lunch_included' => $package->lunch_included,
                'dinner_included' => $package->dinner_included,
                'meal_not_included' => $package->meal_not_included,
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
                'gallery_json' => $package->gallery_json
            ],
        ];

        return json_encode($json);
    }

    // public function actionStep4()
    // {
    //     $feed_models = Feeds::find()->where(['collection' => 2, 'status' => 1])->all();
    //     foreach ($feed_models as $feed) {
    //         $package = Package::find()->where(['id' => $feed->collection_id, 'status' => 1])->limit(1)->one();
    //         if ($package) {
    //             $operator = SafariOperator::find()->where(['id' => $package->safari_operator_id, 'status' => 1])->limit(1)->one();
    //             if ($operator) {
    //                 $feed->status = 1;
    //             } else {
    //                 $feed->status = 0;
    //             }
    //             $feed->save(false);
    //         }
    //     }
    // }
}
