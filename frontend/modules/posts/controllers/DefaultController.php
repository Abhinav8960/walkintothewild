<?php

namespace frontend\modules\posts\controllers;


use common\models\UserPosts;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * 
     * @return string
     */
    public function actionView($eid)
    {
        $id = base64_decode($eid);
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            \Yii::$app->session->setFlash('success', 'Post not found!!');
            return $this->redirect(['/']);
        }
        return $this->render('view', ['userpost' => $userpost]);
    }
}
