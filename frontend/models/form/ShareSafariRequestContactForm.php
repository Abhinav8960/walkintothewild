<?php

namespace frontend\models\form;

use Yii;
use common\interfaces\StatusInterface;
use common\models\share_safari_id\ShareSafari;
use common\models\sharesafari\ShareSafariHistory;
use common\models\sharesafari\ShareSafariRequestContact;

class ShareSafariRequestContactForm extends \yii\base\Model
{
    public $shared_safari_request_contact_model;
    public $host_user_id;
    public $share_safari_id;
    public $share_safari_comment_id;
    public $park_id;
    public $user_id;
    public $request_token;
    public $email;
    public $name;
    public $phone_no;
    public $user_device;
    public $user_agent;
    public $user_platform;
    public $user_browser;
    public $user_ip_address;
    public $status;
    public $is_filled;

    public $action_url;
    public $action_validate_url;


    public function __construct(ShareSafariRequestContact $shared_safari_request_contact_model = null)
    {
        $this->shared_safari_request_contact_model = Yii::createObject([
            'class' => ShareSafariRequestContact::className()
        ]);
        if ($shared_safari_request_contact_model  != '') {
            $this->shared_safari_request_contact_model = $shared_safari_request_contact_model;

            $this->host_user_id =  $this->shared_safari_request_contact_model->host_user_id;
            $this->share_safari_id =  $this->shared_safari_request_contact_model->share_safari_id;
            $this->share_safari_comment_id =  $this->shared_safari_request_contact_model->share_safari_comment_id;
            $this->park_id =  $this->shared_safari_request_contact_model->park_id;
            $this->user_id =  $this->shared_safari_request_contact_model->user_id;
            $this->request_token =  $this->shared_safari_request_contact_model->request_token;
            $this->email =  $this->shared_safari_request_contact_model->email;
            $this->name =  $this->shared_safari_request_contact_model->name;
            $this->phone_no =  $this->shared_safari_request_contact_model->phone_no;
            $this->user_device =  $this->shared_safari_request_contact_model->user_device;
            $this->user_agent =  $this->shared_safari_request_contact_model->user_agent;
            $this->user_platform =  $this->shared_safari_request_contact_model->user_platform;
            $this->user_browser =  $this->shared_safari_request_contact_model->user_browser;
            $this->user_ip_address =  $this->shared_safari_request_contact_model->user_ip_address;
            $this->is_filled =  $this->shared_safari_request_contact_model->is_filled;
            $this->status =  $this->shared_safari_request_contact_model->status;
        }
    }

    public function rules()
    {
        return [
            [['share_safari_id', 'is_filled', 'park_id', 'host_user_id', 'user_id', 'share_safari_comment_id', 'status'], 'integer'],
            [['name', 'user_device', 'user_agent', 'user_platform', 'user_browser', 'user_ip_address', 'request_token'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
            [['phone_no'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['phone_no', 'name', 'email'], 'required'],
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'park_id' => 'Park ID',
            'request_token' => 'Request Token',
            'share_safari_comment_id' => 'Share Safari Comment ID',
            'user_id' => 'User ID',
            'email' => 'Email',
            'name' => 'Name',
            'phone_no' => 'Phone No',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_browser' => 'User Browser',
            'user_ip_address' => 'User Ip Address',
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
        $this->shared_safari_request_contact_model->host_user_id = $this->host_user_id;
        $this->shared_safari_request_contact_model->share_safari_id = $this->share_safari_id;
        $this->shared_safari_request_contact_model->share_safari_comment_id = $this->share_safari_comment_id;
        $this->shared_safari_request_contact_model->park_id = $this->park_id;
        $this->shared_safari_request_contact_model->user_id = $this->user_id;
        $this->shared_safari_request_contact_model->request_token = $this->request_token;
        $this->shared_safari_request_contact_model->email = $this->email;
        $this->shared_safari_request_contact_model->name = $this->name;
        $this->shared_safari_request_contact_model->phone_no = $this->phone_no;
        $this->shared_safari_request_contact_model->user_device = $this->user_device;
        $this->shared_safari_request_contact_model->user_agent = $this->user_agent;
        $this->shared_safari_request_contact_model->user_platform = $this->user_platform;
        $this->shared_safari_request_contact_model->user_browser = $this->user_browser;
        $this->shared_safari_request_contact_model->user_ip_address = $this->user_ip_address;
        $this->shared_safari_request_contact_model->is_filled = $this->is_filled;
        $this->shared_safari_request_contact_model->status = $this->status;
    }
}
