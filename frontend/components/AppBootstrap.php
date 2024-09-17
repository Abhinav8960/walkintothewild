<?php

namespace frontend\components;

use Yii;
use yii\base\Application;
use common\models\UserSession;
use yii\base\BootstrapInterface;

class AppBootstrap implements BootstrapInterface
{
    /** 
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {

        $webasset = Yii::$app->view->assetManager->getBundle('frontend\assets\FrontAppAsset');
        Yii::$app->view->params['baseurl'] = $webasset->baseUrl;

        $session = Yii::$app->session;
        if (!$session->get('user_session_id')) {
            $session->set('user_session_id', session_create_id('user-session'));
        }

        // Update session timestamp if user is logged in
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->status !== \common\models\User::STATUS_ACTIVE) {
                \Yii::$app->user->logout();
                Yii::$app->session->setFlash('Your Account is deactivated! Please Contact Support');
            }
            $sessionId = Yii::$app->session->getId();
            $userId = Yii::$app->user->id;
            Yii::$app->db->createCommand()
                ->update('user_session', [
                    'last_activity' => new \yii\db\Expression('NOW()')
                ], ['id' => $sessionId])
                ->execute();
            $sessionCount = UserSession::find()
                ->where(['user_id' => $userId])
                ->andWhere(['app_name' => Yii::$app->params['app_name']])
                ->count();

            if ($sessionCount > Yii::$app->params['user.maxLoginAccount']) {
                $last_active_user_id = UserSession::find()->select(['id'])->where(['user_id' => $userId, 'app_name' => Yii::$app->params['app_name']])->andWhere("id <>'$sessionId'")->orderby(['last_activity' => SORT_ASC])
                    ->Scalar();
                if ($last_active_user_id) {
                    Yii::$app->db->createCommand()
                        ->delete('user_session', ['id' => $last_active_user_id])
                        ->execute();
                }
            }


            $currentToken = $session->get('session_token');
            $sessionRecord = Yii::$app->db->createCommand('SELECT token FROM user_session WHERE app_name="' . Yii::$app->params['app_name'] . '" and  id = :id')
                ->bindValue(':id', $session->getId())
                ->queryScalar();

            if ($currentToken !== $sessionRecord) {
                // Yii::$app->user->logout(); // stop logout for some time
                // Yii::$app->session->setFlash('Your Session is Expired! Please Login to Continue');
            }
        }
    }
}
