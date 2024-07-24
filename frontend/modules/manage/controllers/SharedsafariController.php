<?php

namespace frontend\modules\manage\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use frontend\controllers\FrontendBaseController;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariParklist;
use frontend\models\form\CreateDepartureForm;

/**
 * Default controller for the `manage` module
 */
class SharedsafariController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();
        $fixed_safari = ShareSafari::find()->where(['host_user_id' => $safari_operator->id, 'status' => 1, 'type' => 2]);
        $fixed_safari_provider = new ActiveDataProvider([
            'query' => $fixed_safari,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render(
            'index',
            [
                'safari_operator' => $safari_operator,
                'fixed_safari_provider' => $fixed_safari_provider,
            ]
        );
    }

    public function actionCreateFixedDeparture()
    {
        $safari_operator = $this->module->operatormodel();

        $model = new CreateDepartureForm();
        $model->host_user_id =  $safari_operator->id;
        $model->type = 2;
        $model->host_type = Yii::$app->user->identity->account_type;
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->action_url = '/manage/sharedsafari/create-fixed-departure';
        $model->action_validate_url = '/manage/sharedsafari/departure-validate';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        $parks = $model->park_list;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_model->id;
                                $park_model->park_id = $park;
                                $park_model->save(false);
                            }
                        }
                        \Yii::$app->session->setFlash('success', 'Fixed Departure Created Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_fixed_departure_form', [
                'model' => $model,
            ]);
        } else {
            return $this->render('_fixed_departure_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionDepartureValidate()
    {
        $model = new CreateDepartureForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionUpdateFixedDeparture($slug)
    {
        $shared_safari_departure_model = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->action_url = '/manage/sharedsafari/update-fixed-departure?slug=' . $slug . '';
        $model->action_validate_url = '/manage/sharedsafari/update-departure-validate?id=' . $shared_safari_departure_model->id . '';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        $parks = $model->park_list;
                        if ($parks) {
                            ShareSafariParklist::deleteAll(['share_safari_id' => $shared_safari_departure_model->id]);
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_model->id;
                                $park_model->park_id = $park;
                                $park_model->save(false);
                            }
                        }
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(\yii\helpers\Url::toRoute(['/manage/sharedsafari/index']));
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_fixed_departure_form', [
                'model' => $model,
            ]);
        } else {
            return $this->render('_fixed_departure_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateDepartureValidate($id)
    {
        if ($id != null) {
            $shared_safari_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
            $model = new CreateDepartureForm($shared_safari_model);
        } else {

            $model = new CreateDepartureForm();
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}
