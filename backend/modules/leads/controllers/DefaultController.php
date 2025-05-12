<?php

namespace backend\modules\leads\controllers;

use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuoteInstallments;
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
                        'allow' => true,
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
        $quotations = $model->quotation;
        return $this->render('view', [
            'model' => $model,
            'quotations' => $quotations,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApprove()
    {
        $id = Yii::$app->request->post('id');
        $paymentUrl = Yii::$app->request->post('payment_url');

        $quotation = LeadPartnerQuotes::findOne($id);
        $installment = LeadPartnerQuoteInstallments::find()->where(['lead_partner_quote_id' => $id])->one();
        if ($quotation) {
            $quotation->is_approved_by_admin = LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED; // Update status to approved
            $quotation->datetime_of_approval_by_admin = date('Y-m-d H:i:s'); // Update status to approved
            $installment->payment_link = $paymentUrl; // Save the payment URL
            if ($quotation->save() && $installment->save(false)) {
                return $this->asJson(['success' => true]);
            } else {
                return $this->asJson(['success' => false, 'message' => 'Failed to approve the quotation.']);
            }
        }
        return $this->asJson(['success' => false, 'message' => 'Quotation not found.']);
    }

    public function actionDisapprove()
    {
        $id = Yii::$app->request->post('id');
        $reason = Yii::$app->request->post('reason');

        $quotation = LeadPartnerQuotes::findOne($id);
        if ($quotation) {
            $quotation->is_approved_by_admin = LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_REJECT; // Update status to approved
            $quotation->datetime_of_approval_by_admin = date('Y-m-d H:i:s'); // Update status to approved
            ; // Update status to disapproved
            $quotation->rejection_reason = $reason; // Save the rejection reason
            if ($quotation->save()) {
                return $this->asJson(['success' => true]);
            } else {
                return $this->asJson(['success' => false, 'message' => 'Failed to disapprove the quotation.']);
            }
        }
        return $this->asJson(['success' => false, 'message' => 'Quotation not found.']);
    }
}
