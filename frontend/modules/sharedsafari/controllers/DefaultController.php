<?php

namespace frontend\modules\sharedsafari\controllers;

use common\interfaces\StatusInterface;
use common\models\sharesafari\ShareSafari;
use frontend\controllers\FrontendBaseController;
use frontend\models\SharedSafariForm;
use Yii;
use yii\web\NotFoundHttpException;

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
        $shared_safari = ShareSafari::find()->where(['status' => 1])->all();
        return $this->render('index', [
            'shared_safari' => $shared_safari
        ]);
    }


    public function actionOrganizeSafari()
    {
        $model = new SharedSafariForm();
        $model->host_user_id = Yii::$app->user->identity->id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/sharedsafari/default';
        $model->action_validate_url = '/sharedsafari/default/validate';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_model->save(false)) {
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
}
