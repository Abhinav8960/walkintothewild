<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use common\models\UserSession;
use common\models\UserSessionSearch;

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
        $searchModel = new UserSessionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
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
            ->delete('user_session', 'last_activity < NOW() - INTERVAL 720 MINUTE') // Extend to 12 hours
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

    public function actionUserList($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $users = UserSession::find()
            ->select(['user_id', 'user.name', 'user.email'])
            ->joinWith('user')
            ->andFilterWhere(['like', 'user.name', $q])
            ->orFilterWhere(['like', 'user.email', $q])
            ->orderBy(['user.name'=>SORT_ASC])
            ->limit(20)
            ->asArray()
            ->distinct()
            ->all();

        $results = [];

        foreach ($users as $user) {
            $results[] = [
                'id' => $user['user_id'],
                'text' => $user['name'] . ' (' . $user['email'] . ')',
            ];
        }

        return ['results' => $results];
    }
}
