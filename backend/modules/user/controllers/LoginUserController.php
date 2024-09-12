<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use common\models\UserSession;
use yii\data\ActiveDataProvider;

/**
 * Login User controller for the `user` module
 */
class LoginUserController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $query = UserSession::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['last_activity' => SORT_DESC]]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Create a New User
     */
    public function actionDestory($session_id)
    {
        $user_session = UserSession::find()->where(['id' => $session_id])->one();
        if ($user_session) {
            $user_session->delete();
        }

        Yii::$app->session->setFlash('User Session Destoryed');
        return $this->redirect(Yii::$app->request->referrer ? Yii::$app->request->referrer : '/');
    }


    /**
     * Destory the User Session that are inactive more then 2 hours
     */
    public function actionDestoryinactive()
    {
        $user_affected = Yii::$app->db->createCommand()
            ->delete('user_session', 'last_activity < NOW() - INTERVAL 120 MINUTE')
            ->execute();

        Yii::$app->session->setFlash($user_affected . ' User Session Destoryed');
        return $this->redirect(Yii::$app->request->referrer ? Yii::$app->request->referrer : '/');
    }

    /**
     * Destory the All Users Session
     */
    public function actionDestoryall()
    {
        $user_affected = Yii::$app->db->createCommand()
            ->delete('user_session', '1=1')
            ->execute();

        Yii::$app->session->setFlash($user_affected . ' User Session Destoryed');
        return $this->redirect(Yii::$app->request->referrer ? Yii::$app->request->referrer : '/');
    }
}
