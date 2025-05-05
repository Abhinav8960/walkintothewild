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

        $this->layout = 'blank';
        $session = Yii::$app->session;

        $model = new CustomLoginForm();

        // Set username and google_source_id if provided
        if ($username !== null) {
            $model->username = $username;
        }

        if ($google_source_id !== null) {
            $model->google_source_id = $google_source_id;
        }
        $session->set('user_session_id', session_create_id('user-session').'_'.time());


        // if (!Yii::$app->user->isGuest) {
        //     $session = Yii::$app->session;

        //     // Check if the session has 'user_session_id' and delete it from the database
        //     if ($session->has('user_session_id')) {
        //         $userSessionId = $session->get('user_session_id');

        //         // Ensure the session ID is valid before attempting to delete
        //         if (!empty($userSessionId)) {
        //             try {
        //                 Yii::$app->db->createCommand()
        //                     ->delete('user_session', ['id' => $userSessionId])
        //                     ->execute();
        //             } catch (\Exception $e) {
        //                 Yii::error('Error deleting user session: ' . $e->getMessage(), __METHOD__);
        //             }
        //         }

        //         // Remove the session key
        //         $session->remove('user_session_id');
        //     }

        //     // Log out the user
        //     // Yii::$app->user->logout();

        //     $user = User::findOne([
        //         'username' => $model->username,
        //         'google_source_id' => $model->google_source_id,
        //     ]);

        //     if (!empty($user)) {

        //         Yii::$app->user->switchIdentity($user);
        //         return $this->goBack();

        //     }
        // } else {
        //     if ($model->login()) {
        //         return $this->goBack();
        //     }
        // }
        if ($model->login()) {
            return $this->goBack();
        }
        return $this->redirect(Yii::$app->request->referrer);


        // $this->layout = 'blank';

        // $model = new CustomLoginForm();

        // // Set username and google_source_id if provided
        // if ($username !== null) {
        //     $model->username = $username;
        // }

        // if ($google_source_id !== null) {
        //     $model->google_source_id = $google_source_id;
        // }

        // Attempt to log in the user
        // if ($model->login()) {
        //     return $this->goBack();
        // }

        // Redirect to the referrer if login fails
    }
}
