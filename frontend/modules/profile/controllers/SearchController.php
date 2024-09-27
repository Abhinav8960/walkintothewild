<?php

namespace frontend\modules\profile\controllers;

use common\models\BlockedModel;
use common\models\User;
use common\models\UserFollow;
use frontend\controllers\FrontendBaseController;
use Yii;

/**
 * SearchController.
 */
class SearchController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('/');
        $user_list = User::find()->where(['status' => 10])->andWhere("user_handle IS NOT NULL")
            ->andWhere('id NOT IN (select blocked_user_id from blocked_user where status = 1)')->all();
        return $this->render('index', ['user_list' => $user_list]);
    }


    public function actionUnblocked($id)
    {
        $blocked_model = BlockedModel::find()->where(['blocked_user_id' => $id, 'user_id' => Yii::$app->user->identity->id])->limit(1)->one();
        if ($blocked_model) {
            $blocked_model->status = 0;
            if ($blocked_model->save(false)) {
                Yii::$app->session->setFlash('success', "Unblocked Successfully!!");
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionBlocked($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if (Yii::$app->user->identity->id == $user->id) {
            Yii::$app->session->setFlash('error', "You can't Block yourself!");
            return $this->redirect(Yii::$app->request->referrer);
        }

        // Follower
        $follow_user = UserFollow::find()->where(['follow_user_id' => $user->id, 'user_id' => Yii::$app->user->identity->id])->limit(1)->one();
        if ($follow_user) {
            $follow_user->status = 0;
            $follow_user->save(false);
        }

        // My Following
        $following_user = UserFollow::find()->where(['user_id' => $user->id, 'follow_user_id' => Yii::$app->user->identity->id])->limit(1)->one();
        if ($following_user) {
            $following_user->status = 0;
            $following_user->save(false);
        }



        $model = BlockedModel::find()->where(['user_id' => Yii::$app->user->identity->id, 'blocked_user_id' => $user->id])->limit(1)->one();
        if (!$model) {
            $model = new BlockedModel();
        }
        $model->user_id = Yii::$app->user->identity->id;
        $model->blocked_user_id = $user->id;
        $model->status = 1;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', "Blocked Successfully!!");
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
}
