<?php

namespace frontend\modules\profile\controllers;

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
    public function actionIndex()
    {
        return $this->render('index', ['user' => $this->module->user()]);
    }

    public function actionFollow($id)
    {
        if (Yii::$app->user->identity) {
            if (Yii::$app->user->identity->id == $id) {
                Yii::$app->session->setFlash('error', "You can't follow yourself!");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $follower = UserFollow::find()->where(['follow_user_id' => Yii::$app->user->identity->id, 'user_id' => $id])->one();
            if (!$follower) {
                $follower = new UserFollow();
            }
            $follower->follow_user_id = Yii::$app->user->identity->id;
            $follower->user_id = $id;
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
            $follower = UserFollow::find()->where(['follow_user_id' => Yii::$app->user->identity->id, 'user_id' => $id])->one();
            $follower->follow_user_id = Yii::$app->user->identity->id;
            $follower->user_id = $id;
            $follower->status = 0;
            $follower->save(false);
            Yii::$app->session->setFlash('success', "Unfollow Successfully!!");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
