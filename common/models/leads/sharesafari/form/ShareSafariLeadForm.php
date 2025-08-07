<?php

namespace common\models\leads\sharesafari\form;

use Yii;
use yii\base\Model;
use common\models\leads\sharesafari\ShareSafariLead;

/**
 * PackageQuoteForm is the model behind the contact form.
 */
class ShareSafariLeadForm extends Model
{
    public $share_safari_id;
    public $share_safari_user_id;
    public $share_safari_partner_id;
    public $version;
    public $type;

    public $seat;
    public $notes;
    public $user_id;
    public $name;
    public $email;
    public $phone;

    public $start_date;
    public $end_date;

    public $gross_price;
    public $discount = 0;
    public $net_price;
    public $installment = 1;
    public $collection;
    public $status;
    public $form_model;


    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['name', 'email', 'phone', 'share_safari_partner_id', 'version', 'type', 'notes', 'start_date', 'end_date', 'gross_price', 'discount', 'net_price', 'installment'], 'safe'],
    //         [['seat', 'share_safari_id', 'share_safari_user_id', 'user_id'], 'required', 'message' => '{attribute} is Required'],
    //         [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
    //         [['notes'], 'string', 'max' => 1000],
    //         [['name'], 'string', 'max' => 255],
    //         [['email'], 'email'],
    //         [['phone'], 'string', 'max' => 15],
    //         [['gross_price', 'discount', 'net_price'], 'number'],
    //         [['installment'], 'integer'],
    //         [['status'], 'integer'],
    //         [['share_safari_id', 'share_safari_user_id', 'share_safari_partner_id', 'version', 'type', 'seat', 'user_id'], 'integer'],
    //         [['start_date', 'end_date', 'collection'], 'safe'],
    //         [['gross_price', 'discount', 'net_price'], 'number'],
    //         [['installment'], 'default', 'value' => 1],
    //         [['collection'], 'default', 'value' => null],
    //         [['status'], 'default', 'value' => 1],
    //         [['share_safari_partner_id'], 'default', 'value' => null],
    //         [['seat'],  'min' => 1, 'tooSmall' => 'Seat must be at least 1']


    //     ];
    // }

    public function rules()
    {
        return [
            // Required fields
            [
                ['seat', 'share_safari_id', 'share_safari_user_id', 'user_id'],
                'required',
                'message' => '{attribute} is Required'
            ],

            // Integer fields
            [
                [
                    'share_safari_id',
                    'share_safari_user_id',
                    'share_safari_partner_id',
                    'version',
                    'type',
                    'seat',
                    'user_id',
                    'status',
                    'installment'
                ],
                'integer'
            ],

            // String fields with max length
            [['name'], 'string', 'max' => 255],
            [['notes'], 'string', 'max' => 1000],
            [['phone'], 'string', 'max' => 15],

            // Email validation
            [['email'], 'email'],

            // Number fields
            [
                ['gross_price', 'discount', 'net_price'],
                'number'
            ],

            // Date fields
            [
                ['start_date', 'end_date'],
                'date',
                'format' => 'php:Y-m-d'
            ],

            // Default values
            [['installment'], 'default', 'value' => 1],
            [['status'], 'default', 'value' => 1],
            [['collection'], 'default', 'value' => null],
            [['share_safari_partner_id'], 'default', 'value' => null],

            // Minimum value validations
            [
                ['seat'],
                'integer',
                'min' => 1,
                'tooSmall' => 'Seat must be at least 1'
            ],

            [
                ['seat'],
                'validateSeatAvailability'
            ],

            // Safe attributes for massive assignment
            [
                [
                    'collection',
                    'start_date',
                    'end_date',
                    'notes',
                    'type',
                    'version'
                ],
                'safe'
            ],

            // Custom validation for discount
            // [
            //     ['discount'],
            //     'validateDiscount',
            //     'skipOnEmpty' => true
            // ]
        ];
    }

    /**
     * Validates that discount is not greater than gross price
     * @param string $attribute
     * @param array $params
     */
    // public function validateDiscount($attribute, $params)
    // {
    //     if (!$this->hasErrors() && $this->discount > $this->gross_price) {
    //         $this->addError($attribute, 'Discount cannot be greater than gross price');
    //     }
    // }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'seat' => 'Seat'
        ];
    }

    /**
     * Validates that the requested number of seats does not exceed available seats
     * @param string $attribute
     * @param array $params
     */
    public function validateSeatAvailability($attribute, $params)
    {
        $share_safari = \common\models\sharesafari\ShareSafari::findOne($this->share_safari_id);
        if ($share_safari) {
            $available_seats = $share_safari->share_seat;
            if ($this->$attribute > $available_seats) {
                $this->addError($attribute, "Cannot book more than {$available_seats} available seats");
            }
        } else {
            $this->addError($attribute, 'Invalid safari selected');
        }
    }

    public function store($share_safari, $login_user)
    {

        // $transaction = \Yii::$app->db->beginTransaction();
        // try {
        $lead = new ShareSafariLead();
        $lead->share_safari_id = $share_safari->id;
        $lead->share_safari_user_id = $share_safari->host_user_id;
        $lead->share_safari_partner_id = $share_safari->partner->id ?? null;
        $lead->version = $share_safari->live_version;
        $lead->type = $share_safari->type;
        $lead->quantity = $this->seat;
        $lead->notes = null;
        $lead->user_id = $login_user->id;
        $lead->name = $login_user->name;
        $lead->email = $login_user->email;
        $lead->phone = $login_user->mobile_no;
        $lead->start_date = $share_safari->start_date;
        $lead->end_date = $share_safari->end_date;
        $lead->cost_per_quantity = $share_safari->cost_per_person;
        $lead->gross_price = $this->seat * $share_safari->cost_per_person;
        $lead->discount = 0; // Assuming no discount for now
        $lead->net_price = $lead->gross_price - $this->discount;
        $lead->installment = $this->installment;
        $lead->received_amount = 0; // Assuming no amount received for now
        $lead->is_payment_received = 0; // Assuming payment not received yet
        $lead->payment_receipt = null; // Assuming no payment receipt for now
        $lead->transaction_datetime = null; // Assuming no transaction datetime for now
        $lead->payment_gateway = 1; // Assuming PayU as default payment gateway
        $lead->is_payment_expired = 0; // Assuming payment not expired
        // $collection = $share_safari->toArray(); // Unset interested_users to avoid circular reference
        // unset($collection['interested_users']); // Unset interested_users to avoid circular reference

        // $lead->collection = $collection ?? null;
        $lead->collection = null; // Assuming no collection data for now

        $lead->status = 1;
        $lead->save(false) && $lead->generateInstallment();
        // $transaction->commit();
        return $lead->id;
        // } catch (\Exception $e) {
        //     // If any exception occurs, rollback the transaction
        //     $transaction->rollBack();
        //     // throw $e; // Re-throw the exception to handle it higher up
        //     \Yii::error("Error storing ShareSafariLead: " . $e->getMessage(), __METHOD__);
        //     return false;
        // }
    }
}
