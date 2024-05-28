<?php

namespace backend\controllers;

use common\models\MailLog;
use common\models\MailLogRecipients;
use common\models\User;
use yii\web\Controller;
use yii\web\Response;

/**
 * Aws Mailer Notification Controller
 */
class AwsMailerNotificationController extends Controller
{

    public $enableCsrfValidation = false;
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // die('tyui');
        // $request = file_get_contents('php://input'); 
        // // $request = Yii::$app->request->getRawBody(); 
        // $jsonfile= '/home/betahrms/www/apps/web/assets/sns.php';
        // $fp = fopen($jsonfile, 'w+');
        // fwrite($fp, $request);
        // fclose($fp);
        // exit;
        // $request =  '{"notificationType":"Delivery","mail":{"timestamp":"2023-09-05T08:01:05.508Z","source":"support@triline.in","sourceArn":"arn:aws:ses:ap-south-1:548108762076:identity/support@triline.in","sourceIp":"180.151.20.127","callerIdentity":"inhouse-app-ses-smtp-user.20230821-130925","sendingAccountId":"548108762076","messageId":"0109018a645bffe4-d214d5e4-1dc3-4bfc-91e2-63e4bc82aa98-000000","destination":["mranurag101@gmail.com"],"headersTruncated":false,"headers":[{"name":"From","value":"support@triline.in"},{"name":"To","value":"mranurag101@gmail.com"},{"name":"Subject","value":"Leave Application"},{"name":"MIME-Version","value":"1.0"},{"name":"Content-Type","value":"multipart/alternative;  boundary=\"----=_Part_4225662_872001774.1693900865514\""}],"commonHeaders":{"from":["support@triline.in"],"to":["mranurag101@gmail.com"],"subject":"Leave Application"}},"delivery":{"timestamp":"2023-09-05T08:01:07.467Z","processingTimeMillis":1959,"recipients":["mranurag101@gmail.com"],"smtpResponse":"250 2.0.0 OK  1693900867 r36-20020a635164000000b0056fbf85c743si8976579pgl.790 - gsmtp","remoteMtaIp":"74.125.24.26","reportingMTA":"c180-15.smtp-out.ap-south-1.amazonses.com"}}';+
        $request = file_get_contents('php://input');



        // $request = '{"notificationType":"Bounce","bounce":{"feedbackId":"0109018a6ee14513-fdc8fef7-281c-4871-82df-bdcd98cb85c7-000000","bounceType":"Permanent","bounceSubType":"General","bouncedRecipients":[{"emailAddress":"mranurag101zqawsxedc@gmail.com","action":"failed","status":"5.1.1","diagnosticCode":"smtp; 550-5.1.1 The email account that you tried to reach does not exist. Please try\n550-5.1.1 double-checking the recipient\'s email address for typos or\n550-5.1.1 unnecessary spaces. Learn more at\n550 5.1.1  https://support.google.com/mail/?p=NoSuchUser d66-20020a633645000000b00553a99dd783si1436855pga.778 - gsmtp"}],"timestamp":"2023-09-07T09:02:51.000Z","remoteMtaIp":"74.125.24.26","reportingMTA":"dns; c180-45.smtp-out.ap-south-1.amazonses.com"},"mail":{"timestamp":"2023-09-07T09:02:49.943Z","source":"support@triline.in","sourceArn":"arn:aws:ses:ap-south-1:548108762076:identity/support@triline.in","sourceIp":"65.2.114.30","callerIdentity":"inhouse-app-ses-smtp-user.20230821-130925","sendingAccountId":"548108762076","messageId":"0109018a6ee13e57-21e07d77-ee1f-4f23-997a-305b26423496-000000","destination":["mranurag101zqawsxedc@gmail.com"],"headersTruncated":false,"headers":[{"name":"From","value":"support@triline.in"},{"name":"To","value":"mranurag101zqawsxedc@gmail.com"},{"name":"Subject","value":"Leave Application"},{"name":"MIME-Version","value":"1.0"},{"name":"Content-Type","value":"multipart/alternative;  boundary=\"----=_Part_1931798_1600358584.1694077369948\""}],"commonHeaders":{"from":["support@triline.in"],"to":["mranurag101zqawsxedc@gmail.com"],"subject":"Leave Application"}}}';
        if (empty($request)) {
            throw new \yii\web\NotFoundHttpException();
        }
        $req_arr = json_decode($request, true);
        $this->NotificationType(strtolower($req_arr['Message']['notificationType']), $req_arr);
        return;
    }

    private function NotificationType($type, $request)
    {
        if (isset($request['mail'])) {

            if ($type == 'delivery') {
                $this->delivery($request);
            } elseif ($type == 'bounce') {
                $this->bounce($request);
            } elseif ($type == 'complaint') {
                $this->complaint($request);
            }
        }
        return;
    }

    private function getMailLogId($messageId)
    {
        $m = MailLog::find()->where(['aws_message_id' => $messageId])->one();
        if (!empty($m)) {

            return $m->id;
        }
        return NULL;
    }

    private function delivery($request)
    {
        $messageId =  $request['mail']['messageId'];
        $logid =  $this->getMailLogId($messageId);
        $recipients =  $request['delivery']['recipients'];
        if (!empty($logid)) {
            return  $this->updateMailLog($logid, $recipients, 'is_delivery');
        }
        return;
    }

    private function bounce($request)
    {
        // $messageId =  $request['mail']['messageId'];
        // $useremails =  $request['mail']['destination'];
        // return  $this->updateMailLog($messageId, 'is_bounce') && $this->markemailbounce($useremails);
        $messageId =  $request['mail']['messageId'];
        $logid =  $this->getMailLogId($messageId);
        $recipients_arr =  $request['bounce']['bouncedRecipients'];
        $recipients = array_column($recipients_arr, 'emailAddress');
        if (!empty($logid)) {
            return  $this->updateMailLog($logid, $recipients, 'is_bounce') &&  $this->markemailbounce($recipients);
        }
        return;
    }



    private function complaint($request)
    {
        // $messageId =  $request['mail']['messageId'];
        // return  $this->updateMailLog($messageId, 'is_complaint');

        $messageId =  $request['mail']['messageId'];
        $logid =  $this->getMailLogId($messageId);
        $recipients_arr =  $request['complaint']['complainedRecipients'];
        $recipients = array_column($recipients_arr, 'emailAddress');
        if (!empty($logid)) {
            return  $this->updateMailLog($logid, $recipients, 'is_complaint');
        }
        return;
    }



    private function updateMailLog($logid, $recipients, $col)
    {
        foreach ($recipients as $recipient) {

            $m = MailLogRecipients::find()->where(['mail_log_id' => $logid, 'recipient' => $recipient])->one();

            if (!empty($m)) {
                $m->$col = 1;
                $m->save(false);
            }
        }
        return;
    }

    private function markemailbounce($useremails)
    {

        if (is_array($useremails)) {
            foreach ($useremails as $email) {
                $m = User::find()->where(['email' => $email])->one();
                if (!empty($m)) {
                    $m->is_email_verified = false;
                    $m->save(false);
                }
            }
        }
        return true;
    }
}
