<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;
use common\models\User;
use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\chat\ChatSearch;
use common\models\package\PackageVersion;
use common\models\park\SafariPark;
use common\models\MailLog;
use common\models\GeneralModel;
use common\models\package\PackageQuote;
use common\models\operator\SafariOperator;
use common\models\operator\OperatorQuote;

/**
 * FrontendRequestLogController implements the CRUD actions for FrontendRequestLog model.
 */
class CreateQuoteChatController extends Controller
{
  public function actionIndex()
  {
    //$this->package_quote_chat();
    $this->operator_quote_chat();
  }

  public function package_quote_chat()
  {
    $package_quotes = PackageQuote::find()->where(['status' => true])->orderBY('id DESC')->all();
    if ($package_quotes) {
      foreach ($package_quotes as $qoute) {
        $is_chat_exist = Chat::find()->where(['quote_id' => $qoute->id])->andWhere(['user_id' => $qoute->created_by])->andWhere(['package_id' => $qoute->package_id])->andWhere(['recipient_user_id' => $qoute->package->safarioperator->user_id])->one();

        if (empty($is_chat_exist)) {
          $package = $qoute->package;
          $package_data = Package::find()->where(['id' => $package->id])->asArray()->one();

          $individual_user = User::find()->where(['id' => $package->safarioperator->user_id])->limit(1)->one();

          $chat = new Chat();
          $short_msg = $message = "<b>Package: </b>" . $qoute->package->package_name . "<br/>";
          $message .= "<b>Travelers: </b>" . $qoute->travelers . "<br/>";
          $message .= "<b>Start Date: </b>" . date('M j, Y', strtotime($qoute->start_date)) . "<br/>";

          $chat->generateChatHash();
          $chat->user_id = $qoute->created_by;
          $chat->recipient_user_id = $package->safarioperator->user_id;
          $chat->last_message = $short_msg;
          $chat->last_message_at = time();
          $chat->status = 1;
          $chat->chat_type = 2;
          $chat->package_id = $qoute->package_id;
          $chat->quote_id = $qoute->id;

          if ($chat->save(false)) {
            $chat_message = new ChatMessage();
            $chat_message->chat_id = $chat->id;
            $chat_message->message = $message;
            $chat_message->data = json_encode($package_data);
            $chat_message->status = 1;
            $chat_message->save();
          }
          //end save done quote chat

          if ($package) {
            $operator = SafariOperator::find()->where(['id' => $package->owned_by_id])->limit(1)->one();
            $to_mail = $operator->email;
            $subject = 'New Quote Request for ' . $package->packagename . '';
            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_TOUR_OPERATOR_FREE_QUOTE_REQUEST;
            $req = ['username' => $operator->business_name, 'parkname' => $package->packagename];

            $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
              GeneralModel::sendmailfromlog($maillog_data['log_id']);
            }
          }
        }
      }
    } else {
      echo "package quote not found.....";
    }
  }

  public function operator_quote_chat()
  {
    $operator_quotes = OperatorQuote::find()->where(['status' => true])->orderBY('id DESC')->all();
    if ($operator_quotes) {
      foreach ($operator_quotes as $qoute) {

        $is_chat_exist = Chat::find()->where(['quote_id' => $qoute->id])->andWhere(['user_id' => $qoute->created_by])->andWhere(['park_id' => $qoute->safari_park_id])->one();
        if (empty($is_chat_exist)) {
          $individual_user = User::find()->where(['id' => $qoute->operator->user_id])->limit(1)->one();

          $chat = new Chat();
          $short_msg = $message = "<b>Park: </b>" . $qoute->park->title . "<br/>";
          $message .= "<b>Safaries: </b>" . $qoute->safaris . "<br/>";
          $message .= "<b>Travelers: </b>" . $qoute->travelers . "<br/>";
          $message .= "<b>Stay Category: </b>" . $qoute->staycatgory->title . "<br/>";
          $message .= "<b>Start Date: </b>" . date('M j, Y', strtotime($qoute->start_date)) . "<br/>";
          $message .= "<b>End Date: </b>" . date('M j, Y', strtotime($qoute->end_date)) . "<br/>";

          $chat->generateChatHash();
          $chat->user_id = $qoute->created_by;
          $chat->recipient_user_id = $individual_user->id;
          $chat->last_message = $short_msg;
          $chat->last_message_at = time();
          $chat->status = 1;
          $chat->chat_type = 2;
          $chat->park_id = $qoute->safari_park_id;
          $chat->quote_id = $qoute->id;

          if ($chat->save()) {
            $chat_message = new ChatMessage();
            $chat_message->chat_id = $chat->id;
            $chat_message->message = $message;
            $chat_message->status = 1;
            if ($chat_message->save()) {
              //create mail log
            }
          }
          //save done quote chat

          $to_mail = $qoute->operator->email;
          $subject = 'Request Free Quote';
          $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_FREE_QUOTE;
          $req = ['username' => $qoute->operator->business_name];

          $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
          if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
            GeneralModel::sendmailfromlog($maillog_data['log_id']);
          }
        }
      }
    } else {
      echo "operator quote not found.....";
    }
  }
}
