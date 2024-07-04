<?php

namespace frontend\modules\sharedsafari\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\interfaces\StatusInterface;
use frontend\models\ShareSafariSearch;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariHistory;
use frontend\models\form\SharedSafariForm;
use frontend\controllers\FrontendBaseController;
use common\models\sharesafari\ShareSafariIntrested;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'device' => $this->device(),
        ]);
    }


    public function actionOrganizeSafari()
    {
        $model = new SharedSafariForm();
        $model->host_user_id = Yii::$app->user->identity->id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/sharedsafari/default/organize-safari';
        $model->action_validate_url = '/sharedsafari/default/validate';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_model->save(false)) {
                        $model->UploadFiles($model->shared_safari_model->id);
                        $model->safariHistory();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->shared_safari_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('organize_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionValidate()
    {
        $model = new SharedSafariForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Update Safari
     */
    public function actionUpdate($slug)
    {
        $shared_safari_model = $this->findModel($slug);
        $model = new SharedSafariForm($shared_safari_model);
        $model->action_url = '/sharedsafari/default/update?slug=' . $slug . '';
        $model->action_validate_url = '/sharedsafari/default/updatevalidate?slug=' . $slug . '';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_model->save(false)) {
                        $model->UploadFiles($model->shared_safari_model->id);
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $shared_safari_model->slug]));
                    }
                }
            }
        } else {
            $model->shared_safari_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('organize_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatevalidate($slug)
    {
        $formmodel = $this->findModel($slug);
        $model = new SharedSafariForm($formmodel);


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Shared Safari Detail View
     */
    public function actionView($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return $this->redirect(['index']);
        }

        return $this->render('view', [

            'share_safari' => $share_safari
        ]);
    }


    /**
     * Join Safari
     */
    public function actionJoin($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($share_safari) {
            if (Yii::$app->user->identity) {
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id])->one();
                if (!$share_safari_intrested) {
                    $share_safari_intrested = new ShareSafariIntrested();
                }
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent(Yii::$app->request->userAgent);
                $share_safari_intrested->user_ip_address = Yii::$app->getRequest()->getUserIp();
                $share_safari_intrested->user_agent =  Yii::$app->request->userAgent;
                $share_safari_intrested->user_device  = $agent->device();
                $share_safari_intrested->user_platform = $agent->platform();
                $share_safari_intrested->user_browser = $agent->browser();
                $share_safari_intrested->park_id = $share_safari->park_id;
                $share_safari_intrested->share_safari_id = $share_safari->id;
                $share_safari_intrested->user_id = Yii::$app->user->identity->id;
                $share_safari_intrested->status = 1;
                $share_safari_intrested->intrested_at = time();
                if ($share_safari_intrested->save()) {
                    Yii::$app->session->setFlash('success', 'You Just Join the Shared Safari!');
                } else {
                    Yii::$app->session->setFlash('error', 'You can not Join this Shared Safari currently!');
                }
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]));
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    }


    /**
     * Un Join Safari
     */
    public function actionUnjoin($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($share_safari) {
            if (Yii::$app->user->identity) {
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id])->one();
                if ($share_safari_intrested) {
                    $agent = new \Jenssegers\Agent\Agent();
                    $agent->setUserAgent(Yii::$app->request->userAgent);
                    $share_safari_intrested->user_ip_address = Yii::$app->getRequest()->getUserIp();
                    $share_safari_intrested->user_agent =  Yii::$app->request->userAgent;
                    $share_safari_intrested->user_device  = $agent->device();
                    $share_safari_intrested->user_platform = $agent->platform();
                    $share_safari_intrested->user_browser = $agent->browser();
                    $share_safari_intrested->park_id = $share_safari->park_id;
                    $share_safari_intrested->share_safari_id = $share_safari->id;
                    $share_safari_intrested->user_id = Yii::$app->user->identity->id;
                    $share_safari_intrested->status = 0; //UNfollow
                    $share_safari_intrested->unintrested_at = time();
                    if ($share_safari_intrested->save()) {
                        Yii::$app->session->setFlash('success', 'You are not part of this Shared Safari!');
                    } else {
                        Yii::$app->session->setFlash('error', 'You can not unfollow this Shared Safari currently!');
                    }
                }
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]));
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    }


    /**
     * Show Safari List by user or host
     */
    public function actionSafaribyuser($user_id)
    {
    }

    protected function findModel($slug)
    {
        if (($model = ShareSafari::findOne(['slug' => $slug, 'status' => StatusInterface::STATUS_ACTIVE])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionHistory($slug)
    {
        $history_model = ShareSafariHistory::find()->where(['slug' => $slug, 'status' => StatusInterface::STATUS_ACTIVE])->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('history_view', [
                'history_model' => $history_model
            ]);
        }
    }

    public function actionInterestview($share_safari_id)
    {
        $interest_model = ShareSafariIntrested::find()->where(['share_safari_id' => $share_safari_id, 'status' => StatusInterface::STATUS_ACTIVE])->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('interest_view', [
                'interest_model' => $interest_model
            ]);
        }
    }
}
