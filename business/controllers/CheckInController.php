<?php

namespace business\controllers;

use common\models\CustomLoginForm;
use common\models\User;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class CheckInController extends Controller
{

    public function actionIndex($username = null, $google_source_id = null)
    {
        if (!Yii::$app->user->isGuest) {
            // $session = Yii::$app->session;
            // if ($session->has('user_session_id')) {
            //     Yii::$app->db->createCommand()
            //         ->delete('user_session', ['id' => $session->get('user_session_id')])
            //         ->execute();
            //     $session->remove('user_session_id');
            // }
            // Yii::$app->user->logout();
            if(Yii::$app->user->identity->username == $username){
                return $this->goBack();
            }
        }

        $this->layout = 'blank';
        $session = Yii::$app->session;

        $model = new CustomLoginForm();

        if ($username !== null) {
            $model->username = $username;
        }

        if ($google_source_id !== null) {
            $model->google_source_id = $google_source_id;
        }
        $session->set('user_session_id', session_create_id('user-session'));

        if ($model->login()) {
            return $this->goBack();
        }
        return $this->redirect(Yii::$app->request->referrer);

    }
}
