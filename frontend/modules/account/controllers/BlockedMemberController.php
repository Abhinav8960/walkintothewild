<?php

namespace frontend\modules\account\controllers;

use common\models\BlockedModel;
use common\models\UserFollow;
use Yii;

/**
 * Blocked Members controller for the `account` module
 */
class BlockedMemberController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $model = BlockedModel::find()->where(['user_id' => $user->id])->all();
        return $this->render('index', [
            'model' => $model,
        ]);
    }


    public function actionUnblocked($id)
    {
        $blocked_model = BlockedModel::find()->where(['blocked_user_id' => $id])->limit(1)->one();
        if ($blocked_model) {
            $blocked_model->delete();
            $follow_model = UserFollow::find()->where(['follow_user_id' => $id])->limit(1)->one();
            if ($follow_model) {
                $follow_model->status = 1;
                if ($follow_model->save(false)) {
                    Yii::$app->session->setFlash('success', "Unblocked Successfully!!");
                    return $this->redirect(Yii::$app->request->referrer);
                };
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
