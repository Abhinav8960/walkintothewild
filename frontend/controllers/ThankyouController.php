<?php

namespace frontend\controllers;

use common\interfaces\StatusInterface;
use frontend\models\registration\form\SafarotourRegistrationForm;
use frontend\models\registration\SafariOperatorRequestActivities;
use frontend\models\registration\SafariOperatorRequestPark;
use yii\web\UploadedFile;
use yii\web\Controller;

/**
 *  Home controller
 */
class SafaritourRegistrationController extends Controller
{
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
