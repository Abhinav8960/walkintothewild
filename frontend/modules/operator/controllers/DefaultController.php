<?php

namespace frontend\modules\operator\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ReplyForm;
use frontend\models\CommentForm;
use common\models\park\SafariPark;
use common\models\RenderedContent;
use frontend\models\ArticleSearch;
use yii\web\NotFoundHttpException;
use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use frontend\models\OperatorQuoteForm;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorFollow;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
            // Save rendered content and other details to the database
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $renderedContent = new RenderedContent();
                $renderedContent->created_at = date('Y-m-d H:i:s');
                $renderedContent->url = Yii::$app->request->absoluteUrl;
                $renderedContent->title = Yii::$app->view->title;
                $renderedContent->action_url = Yii::$app->request->url;

                // Save query parameters to a separate column
                $queryParams = Yii::$app->request->getQueryParams();
                $renderedContent->query_params = json_encode($queryParams); // Save query parameters as JSON

                // Add device info and IP address
                $renderedContent->user_agent = Yii::$app->request->userAgent;
                $renderedContent->ip_address = Yii::$app->request->userIP;

                if ($renderedContent->save()) {
                    $transaction->commit();
                } else {
                    Yii::error('Failed to save rendered content: ' . json_encode($renderedContent->errors));
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                Yii::error('Exception occurred while saving rendered content: ' . $e->getMessage());
                $transaction->rollBack();
            }
        });
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $id, 'status' => 1])->all();

        $model = new OperatorQuoteForm();
        $model->action_url = '/operator/' . $id . '';
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->request($operator)) {
            Yii::$app->session->setFlash('success', 'quote Requested Successfully submitted');
            return $this->redirect(['/operator/default/view',  'id' => $id]);
        }

        if (empty($operator)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render(
            'view',
            [
                'operator' => $operator,
                'model' => $model,
                'featured_parks' => $featured_parks,
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
