<?php

namespace business\modules\leads\controllers;

use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use common\models\leads\LeadSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends  Controller
{

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'quotation', 'quotation-validate'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'quotation', 'quotation-validate'],
                        'allow' => $this->isOwner(),
                        'roles' => ['@'],
                    ],

                ],

            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LeadSearch();
        $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams,\Yii::$app->user->identity->operator->id);
        // $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams, 87);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $quotations = $model->getQuotation()->where(['partner_id'=>\Yii::$app->user->identity->operator->id])->all();
        return $this->render('view', [
            'model' => $model,
            'quotations' => $quotations,
        ]);
    }

    public function actionQuotation($id)
    {
        $m = $this->findModel($id);
        $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => \Yii::$app->user->identity->operator->id])->one();
        // $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => 87])->one();
        $model = new LeadPartnerQuotationForm();
        $model->lead_id = $m->id;
        $model->lead_partner_id = $lead_partner->id;
        $model->partner_id = $lead_partner->partner_id;
        $model->partner_id = $lead_partner->partner_id;
        $model->action_url = '/leads/default/quotation?id=' . $id;
        $model->action_validate_url = '/leads/default/quotation-validate?id=' . $id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {

                    if ($model->request(\Yii::$app->user->identity)) {
                        \Yii::$app->session->setFlash('success', 'Quotation Submitted Successfully');
                        return  $this->redirect(Yii::$app->request->referrer);
                    }
                } else {
                    return  $this->redirect(Yii::$app->request->referrer);

                    // print_r($model->getErrors());
                    // die();
                }
            }
            return  $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_quotation_form', [
                'model' => $model
            ]);
        }
    }

    public function actionQuotationValidate($id)
    {
        $m = $this->findModel($id);
        $model = new LeadPartnerQuotationForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }
    }

    protected function findModel($id)
    {
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->joinWith(['assignOperator' => function ($q) {
            $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => \Yii::$app->user->identity->operator->id]);
            // $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => 87]);
        }])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function isOwner()
    {
        $id = \Yii::$app->request->get('id');
        if (!empty($id)) {
            return Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->joinWith(['assignOperator' => function ($q) {
                $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => \Yii::$app->user->identity->operator->id]);
                // $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => 87]);
            }])->exists();
        }
        return false;
    }
}
