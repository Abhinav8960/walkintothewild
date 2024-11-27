<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\MailLog;
use common\models\GeneralModel;
use common\models\ContactForm as Contact;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $message;
    public $phone;
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
            ['message', 'string', 'max' => 255],
            ['phone', 'required', 'message' => 'This  Mobile number cannot be blank.'],
            ['phone', 'match', 'pattern' => "/^[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}$/", 'message' => ' Mobile number should have 10 digits.'],
        ];
        if (\Yii::$app->params['isGoogleV3CaptchaValidateNeeded'] == true) {
            $rule[] = [['reCaptcha'], \kekaadrenalin\recaptcha3\ReCaptchaValidator::className(), 'acceptance_score' => 0];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Save Contatc Query
     *
     * @return void
     */
    public function contactquery()
    {
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $contact = new Contact();
        $contact->name = $this->name;
        $contact->email = $this->email;
        $contact->message = $this->message;
        $contact->phone = $this->phone;
        $contact->status = 1;
        $contact->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $contact->user_agent =  Yii::$app->request->userAgent;
        $contact->user_device  = $agent->device();
        $contact->user_platform = $agent->platform();
        $contact->user_platform_version = $agent->version($contact->user_platform);
        $contact->user_browser = $agent->browser();
        $contact->user_browser_version = $agent->version($contact->user_browser);
        if (Yii::$app->user->identity) {
            $contact->user_id = Yii::$app->user->identity->id;
        }
        if ($contact->save(false)) {
            // Save Mail Log and Sent to Admin
            $to_mail = Yii::$app->params['adminEmail'];
            $subject = 'New Contact Form Submission | ' . $contact->name . ' - ' . date('Y-m-d H:i:s');
            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_CONTACT_FORM_SUBMITTED;
            $req = ['contact' => $contact->attributes];
            $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                GeneralModel::sendmailfromlog($maillog_data['log_id']);
            }
        }
    }
}
