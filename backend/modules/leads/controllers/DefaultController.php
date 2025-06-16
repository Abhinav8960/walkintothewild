<?php

namespace backend\modules\leads\controllers;

use common\models\chat\Chat;
use api\models\chat\ChatMessage;
use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use common\models\leads\LeadSearch;
use common\models\operator\SafariOperator;
use common\models\User;
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
        $searchModel->status = Lead::STATUS_ACTIVE;
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
        $partnerFeesPercentage = Yii::$app->request->post('plateform_partner_fees_percentage');
        $qr_code_file = \yii\web\UploadedFile::getInstanceByName('qr_code_file');

        // print_r($qr_code_file);
        // die();
        $quotation = LeadPartnerQuotes::findOne($id);
        $installment = LeadPartnerQuoteInstallments::find()->where(['lead_partner_quote_id' => $id])->one();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($quotation) {
                // Calculate platform partner fees
                $partnerSellingPrice = $quotation->partner_selling_price;
                $platformPartnerFees = ($partnerSellingPrice * $partnerFeesPercentage) / 100;
                $netSellingPrice = $partnerSellingPrice + $platformPartnerFees;

                // Update quotation details
                $quotation->plateform_partner_fees_percentage = $partnerFeesPercentage;
                $quotation->plateform_partner_fees = $platformPartnerFees;
                $quotation->partner_net_selling_price = $netSellingPrice;
                // $quotation->plateform_customer_discount = $quotation->plateform_customer_discount;
                $quotation->net_payment_price = $quotation->partner_net_selling_price - $quotation->plateform_customer_discount;
                $quotation->is_approved_by_admin = LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED;
                $quotation->datetime_of_approval_by_admin = date('Y-m-d H:i:s');
                $installment->amount = $quotation->net_payment_price;
                $installment->payment_link = $paymentUrl;

                // Handle QR code file upload
                if (!empty($qr_code_file)) {
                    // Retrieve the uploaded file directly



                    // Generate the file name
                    $qrCodeFileName = 'qr_code_' . $quotation->id . '_' . time() . '.' . $qr_code_file->extension;

                    // Define the file path in the RFS storage
                    $qrCodeFilePath = 'qr_codes/' . date('ym') . '/' . $qrCodeFileName;

                    // Save the uploaded file to the RFS storage
                    $qrCodeChecksum = \common\Helper\FsHelper::saveUploadedFile($qr_code_file, $qrCodeFilePath, $qrCodeFileName);

                    if (!$qrCodeChecksum) {
                        throw new \Exception('Failed to upload QR code to RFS.');
                    }

                    // Save the file path in the installment model
                    $installment->qr_code_file = $qrCodeFilePath;
                }

                // Generate PDF
                $content = $this->renderPartial('_quotation_pdf', ['quotation' => $quotation]);
                $pdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);
                $pdf->WriteHTML($content);
                $pdfFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'quotation_' . $quotation->id . '.pdf';
                $pdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

                // Upload PDF to RFS
                $uploadedFile = new \yii\web\UploadedFile([
                    'name' => 'quotation_' . $quotation->id . '.pdf',
                    'tempName' => $pdfFilePath,
                    'type' => 'application/pdf',
                    'size' => filesize($pdfFilePath),
                    'error' => UPLOAD_ERR_OK,
                ]);

                $fileName = 'quotation_' . $quotation->id . '.pdf';
                $filePath = 'quotations/' . date('ym') . '/' . $fileName;

                $checksum = \common\Helper\FsHelper::restrictedsaveUploadedFile($uploadedFile, $filePath, $fileName);

                if (!$checksum) {
                    throw new \Exception('Failed to upload PDF to RFS.');
                }

                $quotation->quotation_filepath = $filePath;

                // Save quotation and installment
                $quotation->save(false);
                $installment->save(false);

                // Trigger events and prepare chat
                new \common\events\operator\QuotationApprovatedByAdmin($quotation, $paymentUrl, $quotation->lead->user_id, $quotation->partner->user_id);
                $this->prepareChat($quotation);
            }
            $transaction->commit();
            return $this->asJson(['success' => true]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->asJson(['success' => false, 'message' => 'Failed to approve the quotation.' . $e->getMessage()]);
        }
    }

    // private function uploadToRfs($filePath, $quotationId)
    // {
    //     // Define the destination path in the RFS storage
    //     $destinationPath = "quotations/" . date('ym') . "/quotation_{$quotationId}.pdf";

    //     // Use the 'rfs' component to upload the file
    //     $rfs = Yii::$app->rfs;

    //     try {
    //         // Read the file content
    //         $fileContent = file_get_contents($filePath);

    //         // Write the file to the RFS storage
    //         $rfs->write($destinationPath, $fileContent);

    //         return ['success' => true, 'path' => $destinationPath];
    //     } catch (\Exception $e) {
    //         return ['success' => false, 'message' => $e->getMessage()];
    //     }
    // }

    public function actionDisapprove()
    {
        $id = Yii::$app->request->post('id');
        $reason = Yii::$app->request->post('reason');

        $quotation = LeadPartnerQuotes::findOne($id);
        if ($quotation) {
            $quotation->is_approved_by_admin = LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_REJECT; // Update status to approved
            $quotation->datetime_of_approval_by_admin = date('Y-m-d H:i:s'); // Update status to approved
            $quotation->rejection_reason = $reason; // Save the rejection reason
            if ($quotation->save()) {
                return $this->asJson(['success' => true]);
            } else {
                return $this->asJson(['success' => false, 'message' => 'Failed to disapprove the quotation.']);
            }
        }
        return $this->asJson(['success' => false, 'message' => 'Quotation or chat not found.']);
    }

    private function prepareChat($quotation)
    {

        // $chat_model = Chat::find()->andWhere(['lead_id' => $quotation->lead_id])->andWhere(['or', ['user_id' => [$quotation->lead->user_id, $quotation->partner->user_id]], ['recipient_user_id' => [$quotation->lead->user_id, $quotation->partner->user_id]]])->andWhere(['chat_type' => 2])->one();

        $chat_model = Chat::find()
            ->andWhere(['lead_id' => $quotation->lead_id])
            ->andWhere([
                'or',
                [
                    'user_id' => $quotation->partner->user_id,
                    'recipient_user_id' => $quotation->lead->user_id
                ],
                [
                    'user_id' => $quotation->lead->user_id,
                    'recipient_user_id' => $quotation->partner->user_id
                ]
            ])
            ->andWhere(['chat_type' => 2])
            ->one();

        if (!$chat_model) {
            return Yii::$app->api->sendFailedResponse([], 'you can not send quote on this chat', 400);
        }

        $message = "Safaris: " . $quotation->safaris;

        if (isset($quotation->park->title)) {
            $message = "Park: " . $quotation->park->title;
            $message .= "\n";
            $message .= "Safaris: " . $quotation->safaris;
        }
        $message .= "\n";
        $message .= "Travelers: " . $quotation->travelers;
        $message .= "\n";
        $message .= "Stay Category: " . @\common\models\GeneralModel::staycategoryoption()[$quotation->stay_category_id];
        $message .= "\n";
        $message .= "Start Date: " . date('M d, Y', strtotime($quotation->start_date));
        $message .= "\n";
        $message .= "End Date: " . date('M d, Y', strtotime($quotation->end_date));
        if (!empty($quotation->validity_date)) {
            $message .= "\n";
            $message .= "Validity Date: " . date('M d, Y', strtotime($quotation->validity_date));
        }
        if (!empty($quotation->permit_booking_date)) {
            $message .= "\n";
            $message .= "Permit Booking Date: " . date('M d, Y', strtotime($quotation->permit_booking_date));
        }
        $message .= "\n";
        $message .= "Notes:";
        $message .= "\n";
        $message .= $quotation->addional_notes;

        Chat::markChatStarted($chat_model, $quotation->partner_id);
        // $x = \api\models\leads\LeadPartnerQuotes::find()->where(['id' => $quotation->id])->one();
        // $data = $x->preparedata;
        // $this->storeMessage($chat_model->id, $quotation->lead->user_id, $message, $data);
        ChatMessage::updateAll(['is_quotation_active' => 0], ['chat_id' => $chat_model->id]);
        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_model->id;
        $chat_message->message = $message;
        $chat_message->is_quotation_message = true;
        $chat_message->quotation_id = $quotation->id;
        $chat_message->is_quotation_active = true;
        // $chat_message->data = json_encode($data);
        $chat_message->status = 1;
        $chat_message->sender_id = $quotation->partner->user_id;

        if ($chat_message->save(false)) {

            $chat = Chat::find()->where(['id' => $chat_model->id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxlength($message);
            $chat->last_message_at = time();
            $chat->sender_id = $quotation->partner->user_id;
            $chat->quote_id = $quotation->id;
            $chat->is_lead_chat_open_for_user = 1;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            return $chat->save(false);
        }

        return false;
    }

    // public function actionPdfGeneration()
    // {
    //     $content = $this->renderPartial('_report_view');
    //     $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

    //     $mpdf->WriteHTML($content);
    //     $mpdf->Output();
    // }

    public function actionOperatorLeadChat($id, $safari_operator_id)
    {
        $model = $this->findModel($id);
        $quotations = $model->quotation;
        $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
        $chat = Chat::find()->where(['status' => 1, 'lead_id' => $id])->andwhere(['or', ['user_id' => $safari_operator_model->user_id], ['recipient_user_id' => $safari_operator_model->user_id]])->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->all();

        return $this->render(
            '_operator_lead_chat',
            [
                'model' => $model,
                'quotations' => $quotations,
                'chat' => $chat,
                'safari_operator_model' => $safari_operator_model,
            ]
        );
    }

    public function actionPaymentReceived($quotation_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $quotation = LeadPartnerQuotes::findOne($quotation_id);
        if (empty($quotation)) {
            return ['success' => false, 'message' => 'The Quotation page does not exist.'];
        }

        if (isset($quotation->lead) && $quotation->lead->is_payment_received == true) {
            return ['success' => false, 'message' => 'Payment already received for this Lead.'];
        }

        $model = new \backend\modules\leads\model\QuotationPaymentReceived($quotation);

        if (Yii::$app->request->isPost) {
            $postData = \Yii::$app->request->post();
            $model->load($postData);

            if ($model->validate()) {

                if ($model->markPaymentReceived()) {
                    return ['success' => true, 'message' => 'Payment marked as received successfully.'];
                } else {
                    return ['success' => false, 'message' => 'Failed to mark payment as received.'];
                }
            } else {
                return ['success' => false, 'message' => 'Validation failed: ' . implode(', ', $model->getFirstErrors())];
            }
        }

        return ['success' => false, 'message' => 'Invalid request method.'];
    }


    public function actionInactive($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->status = Lead::STATUS_SUSPEND;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('success', 'Inactive Successfully!!!');
                return  $this->redirect(['index']);
            }
        }
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->status = Lead::STATUS_ACTIVE;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('success', 'Active Successfully!!!');
                return  $this->redirect(['index']);
            }
        }
    }
}
