<?php

namespace frontend\models\form;

use common\models\package\PackageEnquiry;
use Yii;


class PackageEnquiryForm extends \yii\base\Model
{
    public $package_enquiry_model;
    public $safari_operator_id;
    public $package_id;
    public $user_id;
    public $name;
    public $no_of_travelers;
    public $start_date;
    public $end_date;
    public $email_address;
    public $phone;
    public $status;


    public function __construct(PackageEnquiry $package_enquiry_model = null)
    {
        $this->package_enquiry_model = Yii::createObject([
            'class' => PackageEnquiry::className()
        ]);
        if ($package_enquiry_model  != '') {
            $this->package_enquiry_model = $package_enquiry_model;

            $this->safari_operator_id =  $this->package_enquiry_model->safari_operator_id;
            $this->package_id =  $this->package_enquiry_model->package_id;
            $this->user_id =  $this->package_enquiry_model->user_id;
            $this->name =  $this->package_enquiry_model->name;
            $this->no_of_travelers =  $this->package_enquiry_model->no_of_travelers;
            $this->start_date =  $this->package_enquiry_model->start_date;
            $this->end_date =  $this->package_enquiry_model->end_date;
            $this->email_address =  $this->package_enquiry_model->email_address;
            $this->phone =  $this->package_enquiry_model->phone;
            $this->status =  $this->package_enquiry_model->status;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id', 'package_id', 'user_id', 'no_of_travelers', 'status'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['name', 'email_address'], 'string', 'max' => 512],
            [['phone'], 'string', 'max' => 12],
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_operator_id' => 'Safari Operator ID',
            'package_id' => 'Package ID',
            'user_id' => 'User ID',
            'no_of_travelers' => 'No Of Travelers',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'name' => 'Name',
            'email_address' => 'Email Address',
            'phone' => 'Phone',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_enquiry_model->safari_operator_id = $this->safari_operator_id;
        $this->package_enquiry_model->package_id = $this->package_id;
        $this->package_enquiry_model->user_id = $this->user_id;
        $this->package_enquiry_model->name = $this->name;
        $this->package_enquiry_model->no_of_travelers = $this->no_of_travelers;
        $this->package_enquiry_model->start_date = $this->start_date;
        $this->package_enquiry_model->end_date = $this->end_date;
        $this->package_enquiry_model->email_address = $this->email_address;
        $this->package_enquiry_model->phone = $this->phone;
        $this->package_enquiry_model->status = $this->status;
    }
}
