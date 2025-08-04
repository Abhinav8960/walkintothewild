<?php

namespace common\models\externaloperator\form;

use common\models\externaloperator\ExternalOperator;
use common\models\externaloperator\ExternalOperatorParks;
use yii\base\Model;
use Yii;

class ExternalOperatorForm extends \yii\base\Model
{
    public $id;
    public $park_id;
    public $operator_name;
    public $email;
    public $phone_no;
    public $website;
    public $address;
    public $owner_name;
    public $owner_email;
    public $owner_phone_no;
    public $traffic;
    public $engagement;
    public $seo_performance;
    public $google_rating;
    public $status;
    public $park_list;
    public $externaloperator_model;

    public function __construct(ExternalOperator $externaloperator_model = null)
    {
        $this->externaloperator_model = Yii::createObject([
            'class' => ExternalOperator::className()
        ]);

        if ($externaloperator_model != '') {
            $this->externaloperator_model = $externaloperator_model;

            $this->id = $this->externaloperator_model->id;
            $this->operator_name = $this->externaloperator_model->operator_name;
            $this->email = $this->externaloperator_model->email;
            $this->address = $this->externaloperator_model->address;
            $this->phone_no = $this->externaloperator_model->phone_no;
            $this->website = $this->externaloperator_model->website;
            $this->owner_name = $this->externaloperator_model->owner_name;
            $this->owner_email = $this->externaloperator_model->owner_email;
            $this->owner_phone_no = $this->externaloperator_model->owner_phone_no;
            $this->traffic = $this->externaloperator_model->traffic;
            $this->engagement = $this->externaloperator_model->engagement;
            $this->seo_performance = $this->externaloperator_model->seo_performance;
            $this->google_rating = $this->externaloperator_model->google_rating;


            $this->park_list =  ExternalOperatorParks::find()->select('park_id')->where(['external_operator_id' => $this->externaloperator_model->id, 'status' => 1])->column();
            $this->status = $this->externaloperator_model->status;

        }

        // $this->status_option = GeneralModel::statusoption();
    }

    /**
     * {@inheritdoc}is_offer_premium_budget
     */
    public function rules()
    {
        $rules = [
            [['id','phone_no','status'], 'integer'],
            [['operator_name','phone_no', 'address', 'park_list', 'email' ,'owner_name'], 'required'],
            [['phone_no', 'owner_phone_no'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['owner_email', 'email'], 'email'],
            [['google_rating'], 'number'],
            [['google_rating'], 'number', 'max' => 5],
            [['address','email', 'website', 'operator_name', 'phone_no','traffic','engagement','seo_performance'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['operator_name'], 'default', 'value' => 0],
            [['park_list'], 'safe'],
            [['website'], 'url', 'defaultScheme' => 'http'],
        ];

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operator_name'=>'Operator Name',
            'address' => 'Address',
            'gst' => 'Gst',
            'google_rating' => 'Rating',
            'phone_no' => 'Phone No',
            'email' => 'Email',
            'website' => 'Website',
            'owner_name' => 'Owner Name',
            'owner_phone_no' => 'Owner Phone No',
            'owner_email' => 'Owner Email',
            'google_rating'=>'Google Rating',
            'traffic'=>'Traffic',
            'engagement'=>'Engagement',
            'seo_performance'=>'SEO Performance',
            'status' => 'Status',
        ];
    }

    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->externaloperator_model->id = $this->id;
        $this->externaloperator_model->operator_name = $this->operator_name;
        $this->externaloperator_model->address = $this->address;
        $this->externaloperator_model->phone_no = $this->phone_no;
        $this->externaloperator_model->email = $this->email;
        $this->externaloperator_model->website = $this->website;
        $this->externaloperator_model->owner_name = $this->owner_name;
        $this->externaloperator_model->owner_phone_no = $this->owner_phone_no;
        $this->externaloperator_model->owner_email = $this->owner_email;
        $this->externaloperator_model->seo_performance = $this->seo_performance;
        $this->externaloperator_model->engagement = $this->engagement;
        $this->externaloperator_model->traffic = $this->traffic;
        $this->externaloperator_model->google_rating = $this->google_rating;
        $this->externaloperator_model->status = $this->status;

        // if ($this->park_list) {
        //     $this->externaloperator_model->park_id = $this->park_list[0];
        // }
    }
}
