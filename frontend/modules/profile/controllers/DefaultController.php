<?php

namespace frontend\modules\profile\controllers;

use common\models\BlockedModel;
use common\models\sharesafari\ShareSafari;
use common\models\User;
use common\models\UserFollow;
use frontend\controllers\FrontendBaseController;
use Yii;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $model = ShareSafari::find()->where(['host_user_id' => $user->id])->orderby(['id' => SORT_DESC])->limit(2)->all();
        $model_count = ShareSafari::find()->where(['host_user_id' => $user->id])->count();
        return $this->render(
            'index',
            [
                'user' => $user,
                'model' => $model,
                'model_count' => $model_count
            ]
        );
    }

    public function actionFollow($id)
    {
        if (Yii::$app->user->identity) {
            if (Yii::$app->user->identity->id == $id) {
                Yii::$app->session->setFlash('error', "You can't follow yourself!");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $follower = UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $id])->one();
            if (!$follower) {
                $follower = new UserFollow();
            }
            $follower->user_id = Yii::$app->user->identity->id;
            $follower->follow_user_id = $id;
            $follower->status = 1;
            $follower->save(false);
            Yii::$app->session->setFlash('success', "Follow Successfully!!");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUnfollow($id)
    {
        if (Yii::$app->user->identity) {
            $follower = UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $id])->one();
            $follower->user_id = Yii::$app->user->identity->id;
            $follower->follow_user_id = $id;
            $follower->status = 0;
            $follower->save(false);
            Yii::$app->session->setFlash('success', "Unfollow Successfully!!");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * User Follower
     */
    public function actionFollower($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);

        return $this->render('follower', ['user' => $user]);
    }

    /**
     * User Following
     */
    public function actionFollowing($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);

        return $this->render('following', ['user' => $user]);
    }

    
}
