<?php

namespace frontend\modules\sighting\controllers;

use common\models\sighting\Sighting;
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
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            \Yii::$app->session->setFlash('success', 'Sighting not found!!');
            return $this->redirect(['/']);
        }

        return $this->render('view', ['sighting' => $sighting]);
    }
}
