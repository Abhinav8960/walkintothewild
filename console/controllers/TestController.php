<?php

namespace console\controllers;

use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\cms\banner\Banner;
use common\models\cms\frontendbanner\FrontendBanner;
use common\models\leads\Lead;
use common\models\postscomment\UserPostComment;
use common\models\postscomment\UserPostLike;
use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use common\models\sighting\SightingLike;
use common\models\UserPosts;
use Yii;
use yii\console\Controller;

/**
 * TestController implements the CRUD actions for FrontendRequestLog model.
 */
class TestController extends Controller
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
        foreach($banner_model as $model)
        {
            if($model->image != null)
            {
                $model->image_path = 'banner/2506/'.$model->image;
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
        foreach($banner_model as $model)
        {
            if($model->frontend_banner != null)
            {
                $model->frontend_banner_path = 'frontend_banner/2506/'. $model->frontend_banner;
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
}
