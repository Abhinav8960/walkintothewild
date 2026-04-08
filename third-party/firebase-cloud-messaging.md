# Firebase Cloud Messaging Implementation

## Overview

Firebase Cloud Messaging (FCM) is used in this project for sending push notifications to users. The implementation includes a helper class `FirebaseNotificationHelper` and a model `FirebaseNotificationLog` for logging notifications.

## Step-by-Step Implementation

### 1. Install Firebase PHP SDK

Add the Firebase PHP SDK to your `composer.json`:

```json
{
  "require": {
    "kreait/firebase-php": "^5.0"
  }
}
```

Run `composer update` to install the package.

### 2. Set Up Firebase Project

- Go to the [Firebase Console](https://console.firebase.google.com/).
- Create a new project or select an existing one.
- Enable Cloud Messaging in the project settings.
- Generate a server key and download the service account JSON file.

### 3. Configure Firebase in Yii2

Add the Firebase configuration to your `common/config/main.php` or appropriate config file:

```php
'components' => [
    'firebase' => [
        'class' => 'Kreait\Firebase\Factory',
        'serviceAccount' => '@common/config/firebase-service-account.json', // Path to your service account JSON
    ],
],
```

### 4. Create FirebaseNotificationLog Model

Create a model to log sent notifications. Place it in `common/models/firebasenotification/FirebaseNotificationLog.php`:

```php
<?php
namespace common\models\firebasenotification;

use Yii;
use yii\db\ActiveRecord;

class FirebaseNotificationLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'firebase_notification_log';
    }

    public static function setActivity($template_id, $title, $message, $user_ids, $data, $image_url = null)
    {
        // Implementation to send FCM and log
        // Use Kreait Firebase SDK to send messages
        $firebase = Yii::$app->firebase->createMessaging();

        // Get user tokens from database
        $tokens = UserDevice::find()->where(['user_id' => $user_ids])->select('firebase_token')->column();

        $message = [
            'notification' => [
                'title' => $title,
                'body' => $message,
            ],
            'data' => $data,
        ];

        if ($image_url) {
            $message['notification']['image'] = $image_url;
        }

        $firebase->sendMulticast($message, $tokens);

        // Log the notification
        foreach ($user_ids as $user_id) {
            $log = new self();
            $log->user_id = $user_id;
            $log->template_id = $template_id;
            $log->title = $title;
            $log->message = $message;
            $log->data = json_encode($data);
            $log->sent_at = date('Y-m-d H:i:s');
            $log->save();
        }
    }
}
```

### 5. Create FirebaseNotificationHelper Class

Create the helper class in `common/Helper/FirebaseNotificationHelper.php` with static methods for different notification types, as shown in the existing code.

### 6. Update User Device Model

Ensure you have a `UserDevice` model to store Firebase tokens:

```php
class UserDevice extends ActiveRecord
{
    // Fields: user_id, firebase_token, device_type, etc.
}
```

### 7. Send Notifications

Call the helper methods in your controllers where needed, e.g.:

```php
FirebaseNotificationHelper::sharedSafariJoin($share_safari, $user);
```

### 8. Handle Token Updates

In your API, update Firebase tokens when users log in or refresh tokens.

## Notes

- Ensure proper error handling for FCM failures.
- Respect user notification preferences.
- Test on real devices for push notifications.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\firebase-cloud-messaging.md
