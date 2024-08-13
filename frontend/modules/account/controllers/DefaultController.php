<?php

namespace frontend\modules\account\controllers;

use common\interfaces\StatusInterface;
use common\models\operator\SafariOperator;
use common\models\User;
use Yii;
use yii\web\UploadedFile;
use frontend\models\profile\UserForm;
use frontend\models\registration\form\SafaritourRegistrationForm;
use frontend\models\registration\SafariOperatorRequestActivities;
use frontend\models\registration\SafariOperatorRequestPark;

/**
 * Default controller for the `account` module
 */
class DefaultController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user_model = Yii::$app->user->identity;
        $model = new UserForm($user_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_model->loadDefaultValues();
        }



        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionProfilePhoto()
    {
        $user_model = Yii::$app->user->identity;
        $model = new UserForm($user_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->profile_image = UploadedFile::getInstance($model, 'profile_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_model->loadDefaultValues();
        }



        return $this->render('_profile_image', [
            'model' => $model,
        ]);
    }

    public function actionCoverPhoto()
    {
        $user_model = Yii::$app->user->identity;
        $model = new UserForm($user_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->cover_image = UploadedFile::getInstance($model, 'cover_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_model->loadDefaultValues();
        }



        return $this->render('_cover_image', [
            'model' => $model,
        ]);
    }

    public function actionRegistrationOperator()
    {
        if (Yii::$app->user->identity) {
            $registration_model = SafariOperator::findOne(['user_id' => Yii::$app->user->identity->id]);
            if ($registration_model) {
                return $this->redirect(['/manage']);
            }
        }

        $registration_model = new SafaritourRegistrationForm();
        $registration_model->status = StatusInterface::STATUS_ACTIVE;
        $registration_model->user_id = Yii::$app->user->identity->id;

        $registration_model->action_url = '/safaritour-registration';
        $registration_model->action_validate_url = '/safaritour-registration/validate';

        $registration_model->referrer_url = \Yii::$app->request->referrer;
        if ($this->request->isPost) {
            if ($registration_model->load($this->request->post())) {
                $registration_model->logo = UploadedFile::getInstance($registration_model, 'logo');
                if ($registration_model->validate()) {
                    $registration_model->initializeForm();
                    if ($registration_model->safarioperator_request_model->save(false)) {
                        $registration_model->uploadFile();
                        $parks = $registration_model->park_id;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $safarioperatorrequestpark = new SafariOperatorRequestPark();
                                $safarioperatorrequestpark->safari_operator_request_id = $registration_model->safarioperator_request_model->id;
                                $safarioperatorrequestpark->park_id = $park;
                                $safarioperatorrequestpark->save(false);
                            }
                        }


                        $activities = $registration_model->offers_other_wildlifeactivities;
                        if ($activities) {
                            foreach ($activities as $activity) {
                                $safarioperatorrequestpark = new SafariOperatorRequestActivities();
                                $safarioperatorrequestpark->safari_operator_request_id = $registration_model->safarioperator_request_model->id;
                                $safarioperatorrequestpark->wildlife_activity_id = $activity;
                                $safarioperatorrequestpark->save(false);
                            }
                        }

                        $registration_model->safarioperator_request_model->is_approved = 1;
                        if ($registration_model->safarioperator_request_model->save(false)) {
                            $safari_operator = $registration_model->safarioperator_request_model->safariapproved($registration_model->safarioperator_request_model);
                            if ($safari_operator) {
                                $user = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
                                $user->account_type = $registration_model->account_type;
                                $user->save(false);

                                return $this->redirect(['/operator/default/sharedsafari', 'slug' => $safari_operator->slug]);
                            }
                        }
                    }
                }
            }
        } else {
            $registration_model->safarioperator_request_model->loadDefaultValues();
        }



        return $this->render('_safari_tour_registration', [
            'model' => $registration_model,
        ]);
    }
}
