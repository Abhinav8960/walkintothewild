<?php

namespace common\components;

use common\models\UserSession;
use DateTimeImmutable;
use Yii;
use yii\base\Component;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\Messaging as MessagingErrors;
use Kreait\Firebase\Exception\MessagingException;

/**
 * Class for common API functions
 */
class FirebaseCloudMessaging extends Component
{
    public $factory;
    public $messaging;
    // public $imageUrl = "https://manage.spidernet.in/images/spiderlogo.png";


    public function __construct()
    {
        $this->factory = (new Factory)->withServiceAccount(Yii::getAlias('@common/config/service.json'));
        $this->messaging = $this->factory->createMessaging();
    }


    private function sendNotification($message)
    {
        try {
            $this->messaging->send($message);
        } catch (MessagingErrors\NotFound $e) {
            echo 'The target device could not be found.';
        } catch (MessagingErrors\InvalidMessage $e) {
            echo 'The given message is malformatted.';
        } catch (MessagingErrors\ServerUnavailable $e) {
            $retryAfter = $e->retryAfter();

            echo 'The FCM servers are currently unavailable. Retrying at ' . $retryAfter->format(\DATE_ATOM);

            // This is just an example. Using `sleep()` will block your script execution, don't do this.
            while ($retryAfter <= new DateTimeImmutable()) {
                sleep(1);
            }
        } catch (MessagingErrors\ServerError $e) {
            echo 'The FCM servers are down.';
        } catch (MessagingException $e) {
            // Fallback handling
            echo 'Unable to send message: ' . $e->getMessage();
        }
    }

    // public function sendMulticastNotification($message, $deviceTokens)
    public function sendMulticastNotification($title, $body, $imageUrl, $deviceTokens, $data = [], $topic = NULL, $condition = NULL)
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::fromArray([
                'title' => $title,
                'body' => $body,
                'image' => $imageUrl,
            ]));
        if (!empty($data)) {
            $message = $message->withData($data);
        }
        if (!empty($topic)) {
            $message = $message->toTopic($topic);
        }
        if (!empty($condition)) {
            $message = $message->toCondition($condition);
        }

        $report = $this->messaging->sendMulticast($message, $deviceTokens);

        // echo 'Successful sends: ' . $report->successes()->count() . PHP_EOL;
        // echo 'Failed sends: ' . $report->failures()->count() . PHP_EOL;

        // if ($report->hasFailures()) {
        //     foreach ($report->failures()->getItems() as $failure) {
        //         echo $failure->error()->getMessage() . PHP_EOL;
        //     }
        // }
        // print_r($deviceTokens);
        // die();
        // The following methods return arrays with registration token strings
        // $successfulTargets = $report->validTokens(); // string[]

        // Unknown tokens are tokens that are valid but not know to the currently
        // used Firebase project. This can, for example, happen when you are
        // sending from a project on a staging environment to tokens in a
        // production environment
        $unknownTargets = $report->unknownTokens(); // string[]
        $this->tokendisabled($unknownTargets);

        // Invalid (=malformed) tokens
        $invalidTargets = $report->invalidTokens(); // string[]
        $this->tokendisabled($invalidTargets);
    }

    public function sendNotificationSpecificDevice($title, $body, $token, $data = [], $topic = NULL, $condition = NULL)
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::fromArray([
                'title' => $title,
                'body' => $body,
                'image' => $this->imageUrl,
            ]));
        if (!empty($data)) {
            $message = $message->withData($data);
        }
        if (!empty($topic)) {
            $message = $message->toTopic($topic);
        }
        if (!empty($condition)) {
            $message = $message->toCondition($condition);
        }
        if (!empty($token)) {
            $message = $message->toToken($token);
        }

        $this->sendNotification($message);
    }

    public function validateRegistrationToken($tokens = [])
    {
        if (!empty($tokens)) {
            return  $result = $this->messaging->validateRegistrationTokens($tokens);
        }
        return false;
    }

    public function tokendisabled($tokens = [])
    {
        if (!empty($tokens)) {
            foreach ($tokens as $token) {
                $user = UserSession::find()->where(['firebase_token' => $token])->limit(1)->one();
                if ($user) {
                    $user->is_firebase_token_active = 0;
                    $user->save(false);
                }
            }
        }
        return true;
    }
}
