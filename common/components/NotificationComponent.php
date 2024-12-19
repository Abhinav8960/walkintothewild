<?php

namespace common\components;

use common\models\workspace\Notification;
use Yii;
use yii\base\Component;
use yii\helpers\Json;


/**
 * Class for common API functions
 */
class NotificationComponent extends Component
{


    public function store($recipients, $sender, $source, $source_parameter, $message, $project_id = NULL)
    {


        if (!is_array($recipients)) {
            $recipients[] = $recipients;
        }
        if (count($recipients) > 0) {

            foreach ($recipients as $recipient => $notification_type) {

                if (!empty($recipient)) {

                    $model =  new Notification();
                    $model->project_id = $project_id;
                    $model->recipient_id = $recipient;
                    $model->sender_id = $sender;
                    $model->source = $source;
                    $model->source_parameter = $source_parameter;
                    $model->notification_type = $notification_type;
                    $model->message = $message;
                    $model->status = true;
                    $model->save(false);
                }
            }
        }
        return true;
    }

    public function hide($source, $source_parameter)
    {

        $model = Notification::find()->where(["source" => $source, "source_parameter" => $source_parameter])->one();
        if (!empty($model)) {
            $model->is_hidden = true;
            $model->save(false);
        }
        return true;
    }
}