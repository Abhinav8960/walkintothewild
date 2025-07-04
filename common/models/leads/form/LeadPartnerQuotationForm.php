<?php

namespace common\models\leads\form;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use common\models\GeneralModel;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use Yii;
use yii\base\Model;
use common\models\park\safarisPark;

/**
 * OperatorQuoteForm is the model behind the contact form.
 */
class LeadPartnerQuotationForm extends Model
{

    public $lead_partner_id;
    public $park_id;
    public $addional_notes;
    public $lead_id;
    public $partner_id;
    public $safaris;
    public $travelers;
    public $stay_category_id;
    public $name;
    public $email;
    public $phone;
    public $start_date;
    public $partner_selling_price;
    public $plateform_partner_fees_percentage = 0;
    public $plateform_partner_fees;
    public $partner_net_selling_price;
    public $plateform_customer_discount = 0;
    public $net_payment_price;
    public $installment = 1;
    public $received_amount = 0;
    public $end_date;
    public $addtional_data;
    public $status;

    public $action_url;
    public $action_validate_url;
    public $validity_date;
    public $permit_booking_date;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['addtional_data', 'addional_notes'], 'default', 'value' => null],
            [['received_amount'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['park_id', 'lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'start_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'end_date'], 'required'],
            [['lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'status'], 'integer'],
            [['start_date', 'end_date', 'addtional_data', 'action_url', 'action_validate_url', 'name', 'email', 'phone'], 'safe'],
            [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'received_amount'], 'number'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            ['start_date', 'date', 'format' => 'php:Y-m-d'],
            ['end_date', 'date', 'format' => 'php:Y-m-d'],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>='],
            [['partner_selling_price'], 'integer', 'max' => 9999999],
            [['validity_date'], 'date', 'format' => 'php:Y-m-d'],
            [['permit_booking_date'], 'date', 'format' => 'php:Y-m-d'],
            [['validity_date'], 'compare', 'compareValue' => date("Y-m-d"), 'operator' => '>='],
            [['permit_booking_date'], 'compare', 'compareValue' => date("Y-m-d"), 'operator' => '>='],
            [['validity_date', 'permit_booking_date'], 'safe'],


        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_partner_id' => 'Lead Partner ID',
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'safaris' => 'safaris',
            'travelers' => 'travelers',
            'stay_category_id' => 'Accomodation',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'start_date' => 'Start Date',
            'partner_selling_price' => 'Partner Selling Price',
            'plateform_partner_fees_percentage' => 'Plateform Partner Fees Percentage',
            'plateform_partner_fees' => 'Plateform Partner Fees',
            'partner_net_selling_price' => 'Partner Net Selling Price',
            'plateform_customer_discount' => 'Plateform Customer Discount',
            'net_payment_price' => 'Net Payment Price',
            'installment' => 'Installment',
            'received_amount' => 'Recived Amount',
            'end_date' => 'End Date',
            'addtional_data' => 'Addtional Data',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'validity_date' => 'Validity Date',
            'permit_booking_date' => 'Permit Booking Date',
        ];
    }

    public function request($login_user)
    {

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $lead = Lead::find()->where(['id' => $this->lead_id])->one();
            $lead_partner = LeadPartners::find()->where(['lead_id' => $this->lead_id, 'partner_id' => $this->partner_id])->one();

            $lpq = new LeadPartnerQuotes();
            $lpq->lead_partner_id = $this->lead_partner_id;
            $lpq->park_id = $this->park_id;
            $lpq->addional_notes = $this->addional_notes;
            $lpq->lead_id = $this->lead_id;
            $lpq->partner_id = $this->partner_id;
            $lpq->safaris = $this->safaris;
            $lpq->travelers = $this->travelers;
            $lpq->stay_category_id = $this->stay_category_id;
            $lpq->name = $lead->name ?? $this->name;
            $lpq->email = $lead->email ?? $this->email;
            $lpq->phone = $lead->phone ?? $this->phone;
            $lpq->start_date = $this->start_date;
            $lpq->partner_selling_price = $this->partner_selling_price;
            $lpq->plateform_partner_fees_percentage = $this->plateform_partner_fees_percentage;
            $lpq->plateform_partner_fees = $this->calculate_plateform_partner_fees();
            $lpq->partner_net_selling_price = $this->calculate_partner_net_selling_price();
            $lpq->plateform_customer_discount = $this->plateform_customer_discount;
            $lpq->net_payment_price = $this->calculate_net_payment_price();
            $lpq->installment = $this->installment;
            $lpq->received_amount = $this->received_amount;
            $lpq->end_date = $this->end_date;
            $lpq->addtional_data = $this->addtional_data;
            $lpq->validity_date = $this->validity_date;
            $lpq->permit_booking_date = $this->permit_booking_date;
            $lpq->status = 1;
            $lpq->save(false);

            $installment = new LeadPartnerQuoteInstallments();
            $installment->lead_partner_quote_id = $lpq->id;
            $installment->lead_id = $lpq->lead_id;
            $installment->partner_id = $lpq->partner_id;
            $installment->amount = $lpq->net_payment_price;
            $installment->payment_hash = Yii::$app->security->generateRandomString(10) . time() . Yii::$app->security->generateRandomString(5);
            $installment->before_datetime = $this->start_date;
            $installment->created_by = $login_user->id;
            $installment->updated_by = $login_user->id;
            $installment->save(false);

            $lead->quotation_count = $lead->quotation_count + 1;
            $lead->save(false);

            $lead_partner->quotation_count = $lead_partner->quotation_count + 1;
            $lead_partner->save(false);
            $this->markApprove($lpq->id);
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            // If any exception occurs, rollback the transaction
            $transaction->rollBack();
            throw $e; // Re-throw the exception to handle it higher up
        }
    }

    private function calculate_plateform_partner_fees()
    {
        return round($this->partner_selling_price * $this->plateform_partner_fees_percentage / 100, 2);
    }
    private function calculate_partner_net_selling_price()
    {
        return $this->partner_selling_price + $this->calculate_plateform_partner_fees();
    }

    private function calculate_net_payment_price()
    {
        return $this->partner_selling_price + $this->calculate_plateform_partner_fees();
    }

    public function validateTwoHourCondition($attribute, $params)
    {
        $inputTime = strtotime($this->$attribute);
        $currentTime = time();
        $invalideTime = strtotime('+2 hours', $currentTime);

        if ($inputTime < $invalideTime) {
            $this->addError($attribute, 'The ' . $attribute . ' must be greater that 2 hours from current time.');
        }
    }

    public function markApprove($id)
    {
        $payment_hash = GeneralModel::encrypt($id);
        $paymentUrl = \Yii::$app->params['frontend_url_for_payments'] . '/payu/' . $payment_hash;
        $partnerFeesPercentage = Yii::$app->request->post('plateform_partner_fees_percentage') ?? 0;
        // $qr_code_file = \yii\web\UploadedFile::getInstanceByName('qr_code_file');

        // print_r($qr_code_file);
        // die();
        $quotation = LeadPartnerQuotes::findOne($id);
        $installment = LeadPartnerQuoteInstallments::find()->where(['lead_partner_quote_id' => $id])->one();

        if ($quotation) {
            // Calculate platform partner fees
            $partnerSellingPrice = $quotation->partner_selling_price;
            // $platformPartnerFees = ($partnerSellingPrice * $partnerFeesPercentage) / 100;
            $platformPartnerFees = 0;
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
            $installment->payment_hash = $payment_hash;

            // // Handle QR code file upload
            // if (!empty($qr_code_file)) {
            //     // Retrieve the uploaded file directly



            //     // Generate the file name
            //     $qrCodeFileName = 'qr_code_' . $quotation->id . '_' . time() . '.' . $qr_code_file->extension;

            //     // Define the file path in the RFS storage
            //     $qrCodeFilePath = 'qr_codes/' . date('ym') . '/' . $qrCodeFileName;

            //     // Save the uploaded file to the RFS storage
            //     $qrCodeChecksum = \common\Helper\FsHelper::saveUploadedFile($qr_code_file, $qrCodeFilePath, $qrCodeFileName);

            //     if (!$qrCodeChecksum) {
            //         throw new \Exception('Failed to upload QR code to RFS.');
            //     }

            //     // Save the file path in the installment model
            //     $installment->qr_code_file = $qrCodeFilePath;
            // }

            // Generate PDF
            $content = GeneralModel::generatePdf('@backend/modules/leads/views/default/_quotation_pdf', [
                'quotation' => $quotation,
            ]);
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
            $quotation->is_payment_link_send = 1;

            // Save quotation and installment
            $quotation->save(false);
            $installment->save(false);

            $lead_partner = LeadPartners::find()->where(['id' => $quotation->lead_partner_id])->one();
            $lead_partner->is_payment_link_send = 1;
            $lead_partner->save(false);

            $lead = Lead::find()->where(['id' => $quotation->lead_id])->one();
            $lead->is_payment_link_send = 1;
            $lead->save(false);
            // Trigger events and prepare chat
            new \common\events\operator\QuotationApprovatedByAdmin($quotation, $paymentUrl, $quotation->lead->user_id, $quotation->partner->user_id);
            $this->prepareChat($quotation);
            return true;
        }

        return false;
        // return $this->asJson(['success' => false, 'message' => 'Failed to approve the quotation.' . $e->getMessage()]);
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
            return false;
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
}
