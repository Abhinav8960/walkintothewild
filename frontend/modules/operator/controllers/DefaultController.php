<?php

namespace frontend\modules\operator\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorFollow;
use frontend\models\OperatorQuoteForm;
use frontend\controllers\FrontendBaseController;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{
    public $enableCsrfValidation = false;

    public $action_ids = ['view', 'follow', 'unfollow'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if (empty($operator)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $id, 'status' => 1])->all();
        $model = new OperatorQuoteForm();
        $model->action_url = '/operator/' . $id . '';
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->request($operator)) {
            Yii::$app->session->setFlash('success', 'quote Requested Successfully submitted');
            return $this->redirect(['/operator/default/view',  'id' => $id]);
        }


        return $this->render(
            'view',
            [
                'operator' => $operator,
                'model' => $model,
                'operator_parks' => $operator_parks,
            ]
        );
    }


    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidate($id = null)
    {
        $model = new OperatorQuoteForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new OperatorQuoteForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Follow Operator
     */
    public function actionFollow($id)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if ($operator) {
            if (Yii::$app->user->identity) {
                $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $id])->one();
                if (!$operator_follow) {
                    $operator_follow = new SafariOperatorFollow();
                }
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent(Yii::$app->request->userAgent);
                $operator_follow->user_ip_address = Yii::$app->getRequest()->getUserIp();
                $operator_follow->user_agent =  Yii::$app->request->userAgent;
                $operator_follow->user_device  = $agent->device();
                $operator_follow->user_platform = $agent->platform();
                $operator_follow->user_platform_version = $agent->version($operator_follow->user_platform);
                $operator_follow->user_browser = $agent->browser();
                $operator_follow->user_browser_version = $agent->version($operator_follow->user_browser);
                $operator_follow->safari_operator_id = $id;
                $operator_follow->user_id = Yii::$app->user->identity->id;
                $operator_follow->status = 1;
                $operator_follow->follow_datetime = date('Y-m-d h:i:s');
                if ($operator_follow->save()) {
                    Yii::$app->session->setFlash('success', 'Operator is Followed!');
                } else {
                    Yii::$app->session->setFlash('error', 'You can not follow this operator currently!');
                }
            }
        }

        return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/view', 'id' => $id]));
    }


    /**
     * Follow Operator
     */
    public function actionUnfollow($id)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if ($operator) {
            if (Yii::$app->user->identity) {
                $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $id])->one();
                if ($operator_follow) {
                    $agent = new \Jenssegers\Agent\Agent();
                    $agent->setUserAgent(Yii::$app->request->userAgent);
                    $operator_follow->user_ip_address = Yii::$app->getRequest()->getUserIp();
                    $operator_follow->user_agent =  Yii::$app->request->userAgent;
                    $operator_follow->user_device  = $agent->device();
                    $operator_follow->user_platform = $agent->platform();
                    $operator_follow->user_platform_version = $agent->version($operator_follow->user_platform);
                    $operator_follow->user_browser = $agent->browser();
                    $operator_follow->user_browser_version = $agent->version($operator_follow->user_browser);
                    $operator_follow->safari_operator_id = $id;
                    $operator_follow->user_id = Yii::$app->user->identity->id;
                    $operator_follow->status = 0; //UNfollow
                    $operator_follow->unfollow_datetime = date('Y-m-d h:i:s');
                    if ($operator_follow->save()) {
                        Yii::$app->session->setFlash('success', 'Operator is UnFollowed!');
                    } else {
                        Yii::$app->session->setFlash('error', 'You can not unfollow this operator currently!');
                    }
                }
            }
        }

        return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/view', 'id' => $id]));
    }
}
