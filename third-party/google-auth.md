# Google Authentication Implementation

## Overview

Google Authentication is implemented using Yii2's `authclient` extension for OAuth2 login.

## Step-by-Step Implementation

### 1. Install Yii2 AuthClient Extension

Add to `composer.json`:

```json
{
  "require": {
    "yiisoft/yii2-authclient": "~2.2.0"
  }
}
```

Run `composer update`.

### 2. Set Up Google OAuth Credentials

- Go to the [Google Cloud Console](https://console.cloud.google.com/).
- Create a new project or select existing.
- Enable the Google+ API.
- Create OAuth 2.0 credentials (Client ID and Client Secret).
- Add authorized redirect URIs, e.g., `https://yourdomain.com/site/auth?authclient=google`.

### 3. Configure AuthClient in Yii2

Update your config file (e.g., `common/config/main.php`):

```php
'components' => [
    'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'google' => [
                'class' => 'yii\authclient\clients\Google',
                'clientId' => 'YOUR_GOOGLE_CLIENT_ID',
                'clientSecret' => 'YOUR_GOOGLE_CLIENT_SECRET',
            ],
        ],
    ],
],
```

### 4. Create AuthHandler Class

Create a class to handle authentication, e.g., in `common/components/AuthHandler.php`:

```php
<?php
namespace common\components;

use Yii;
use yii\authclient\ClientInterface;
use common\models\User;

class AuthHandler
{
    public static function handle(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();
        $email = $attributes['email'];

        $user = User::find()->where(['email' => $email])->one();
        if (!$user) {
            // Create new user
            $user = new User();
            $user->email = $email;
            $user->name = $attributes['name'];
            $user->status = 10;
            $user->save();
        }

        Yii::$app->user->login($user);
    }
}
```

### 5. Create Auth Action in Controller

In your `SiteController` or auth controller:

```php
public function actions()
{
    return [
        'auth' => [
            'class' => 'yii\authclient\AuthAction',
            'successCallback' => [$this, 'onAuthSuccess'],
        ],
    ];
}

public function onAuthSuccess($client)
{
    AuthHandler::handle($client);
}
```

### 6. Add Login Links

In your view files:

```php
<a href="<?= \yii\helpers\Url::to(['site/auth', 'authclient' => 'google']) ?>">Login with Google</a>
```

### 7. Handle User Data

Ensure your `User` model has fields for email, name, etc.

## Notes

- Customize the `AuthHandler` to fit your user model.
- Handle cases where email is not provided.
- Test the OAuth flow thoroughly.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\google-auth.md
