# Swagger Implementation

## Overview

Swagger (OpenAPI) is used for API documentation in this project using the `zircote/swagger-php` library.

## Step-by-Step Implementation

### 1. Install Swagger PHP

Add to `composer.json`:

```json
{
  "require-dev": {
    "zircote/swagger-php": "^5.5"
  }
}
```

Run `composer update`.

### 2. Create Schema Classes

Create schema classes in `api/swagger/components/schemas/` using OpenAPI annotations. Example:

```php
<?php
namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserSchema",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 * )
 */
class UserSchema
{
}
```

### 3. Annotate API Controllers

Add OpenAPI annotations to your controller actions. Example:

```php
/**
 * @OA\Get(
 *     path="/users",
 *     summary="Get list of users",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/UserSchema")
 *     )
 * )
 */
public function actionIndex()
{
    // Your code
}
```

### 4. Generate Swagger JSON

Create a console command to generate the OpenAPI JSON file. Create `console/controllers/SwaggerController.php`:

```php
<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use OpenApi\Generator;

class SwaggerController extends Controller
{
    public function actionGenerate()
    {
        $openapi = Generator::scan([Yii::getAlias('@api')]);
        $json = $openapi->toJson();
        file_put_contents(Yii::getAlias('@webroot/swagger.json'), $json);
        echo "Swagger JSON generated.\n";
    }
}
```

### 5. Serve Swagger UI

Install Swagger UI or use a Yii2 module. You can serve the JSON file and use Swagger UI to display it.

### 6. Integrate with Yii2

Add routes or actions to serve the Swagger documentation.

## Notes

- Use annotations consistently across all API endpoints.
- Keep schemas updated with model changes.
- Automate generation in deployment scripts.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\swagger-implementation.md
