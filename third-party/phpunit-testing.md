# PHPUnit Testing Implementation

## Overview

PHPUnit is used for unit testing in this Yii2 project. The project includes test configurations and test directories.

## Step-by-Step Implementation

### 1. Install PHPUnit

PHPUnit is already included in `composer.json`:

```json
{
  "require-dev": {
    "phpunit/phpunit": "~9.5.0"
  }
}
```

Run `composer install` if not already installed.

### 2. Configure PHPUnit

Create or update `phpunit.xml` in the project root:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="tests/bootstrap.php"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false">
    <testsuites>
        <testsuite name="WalkIntoWild Test Suite">
            <directory>./tests</directory>
        </testsuite>
    </testsuites>
    <filter>
        <whitelist>
            <directory>./</directory>
            <exclude>
                <directory>./vendor</directory>
                <directory>./tests</directory>
            </exclude>
        </whitelist>
    </filter>
</phpunit>
```

### 3. Create Test Bootstrap

Create `tests/bootstrap.php`:

```php
<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@tests', __DIR__);
```

### 4. Create Test Database Configuration

Create `tests/config.php`:

```php
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=walkintothewild_test',
            'username' => 'root',
            'password' => '',
        ],
    ],
];
```

### 5. Create Unit Test Example

Create a test class, e.g., `tests/unit/models/UserTest.php`:

```php
<?php
namespace tests\unit\models;

use common\models\User;
use Codeception\Test\Unit;

class UserTest extends Unit
{
    public function testFindUserById()
    {
        $user = User::findIdentity(1);
        $this->assertNotNull($user);
        $this->assertEquals(1, $user->id);
    }
}
```

### 6. Run Tests

Run PHPUnit from the command line:

```bash
./vendor/bin/phpunit
```

Or for specific tests:

```bash
./vendor/bin/phpunit tests/unit/models/UserTest.php
```

### 7. Integrate with Codeception (if used)

The project uses Codeception for acceptance and functional tests. Ensure Codeception configs are set up in each module's `codeception.yml`.

## Notes

- Use fixtures for test data.
- Mock external dependencies.
- Run tests in CI/CD pipelines.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\phpunit-testing.md
