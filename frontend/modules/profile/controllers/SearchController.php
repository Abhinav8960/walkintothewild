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
        $user_list = User::find()->where(['status' => 10])->andWhere("user_handle IS NOT NULL")->all();
        return $this->render('index', ['user_list' => $user_list]);
    }


    public function actionUnblocked($id)
    {
        $blocked_model = BlockedModel::find()->where(['blocked_user_id' => $id, 'user_id' => Yii::$app->user->identity->id])->limit(1)->one();
        if ($blocked_model) {
            $blocked_model->status = 2;
            if ($blocked_model->save()) {
                $follow_model = UserFollow::find()->where(['follow_user_id' => $id, 'user_id' => Yii::$app->user->identity->id])->limit(1)->one();
                if ($follow_model) {
                    $follow_model->status = 1;
                    if ($follow_model->save()) {
                        Yii::$app->session->setFlash('success', "Unblocked Successfully!!");
                        return $this->redirect(Yii::$app->request->referrer);
                    };
                }
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionBlocked($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $blocked_user = UserFollow::find()->where(['follow_user_id' => $user->id, 'user_id' => Yii::$app->user->identity->id])->limit(1)->one();
        if ($blocked_user) {
            $blocked_user->status = 2;
            if ($blocked_user->save()) {
                $model = BlockedModel::find()->where(['user_id' => Yii::$app->user->identity->id, 'blocked_user_id' => $user->id])->limit(1)->one();
                if (!$model) {
                    $model = new BlockedModel();
                }
                $model->user_id = $blocked_user->user_id;
                $model->blocked_user_id = $blocked_user->follow_user_id;
                $model->status = 1;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Blocked Successfully!!");
                    return $this->redirect(Yii::$app->request->referrer);
                }
            };
        } else {
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
}
