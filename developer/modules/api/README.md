# Swagger (OpenAPI) Integration in Yii2
A complete guide to integrating Swagger UI and generating API documentation using zircote/swagger-php in a Yii2 (Advanced or Basic Template) application.

## 📌 Features
* Auto-generated OpenAPI 3.0 JSON/YAML
* Clean and interactive Swagger UI
* Supports models, controllers, and annotations
* Custom headers, security schemes (JWT), components, reusable schemas, etc.

## 🛠️ Installation
### 1. Install Swagger-PHP
```
composer require zircote/swagger-php
```
### 2. Install Doctrine Annotations

```
composer require doctrine/annotations
```

## 📁 Folder Structure

```
developer
  └── modules/
        └── api/
             ├── controllers/
             |       ├── DefaultController.php
             └── views/
                   ├── default
                          ├── index.php
            
```

### 3. Create Default Controller

```
<?php

namespace developer\modules\api\controllers;

use yii;
use yii\web\Response;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Action to serve the Swagger JSON dynamically
     */
    public function actionJson()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $openapi = \OpenApi\Generator::scan([
            \Yii::getAlias('@api/controllers'),
            \Yii::getAlias('@api/modules'),
            \Yii::getAlias('@api/swagger/components/schemas'),
        ]);

        $data = json_decode($openapi->toJson(), true);
        $host = Yii::$app->params['api_url'];

        $data['servers'] = [];
        if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
            $data['servers'][] = [
                'url' => $host,
                'description' => 'Auto-detected',
            ];
        }
        $data['servers'][] = [
            'url' => 'https://staging-api.walkintothewild.in/',
            'description' => 'Staging Server',
        ];

        $components = $data['components'] ?? [];

        $components['securitySchemes']['bearerAuth'] = [
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT'
        ];
        $components['securitySchemes']['XDevice'] = [
            'type' => 'apiKey',
            'in'   => 'header',
            'name' => 'x-device',
        ];
        $components['securitySchemes']['XPlatform'] = [
            'type' => 'apiKey',
            'in'   => 'header',
            'name' => 'x-platform',
        ];
        $components['securitySchemes']['XPlatformVersion'] = [
            'type' => 'apiKey',
            'in'   => 'header',
            'name' => 'x-platform-version',
        ];
        $components['securitySchemes']['XApplicationVersion'] = [
            'type' => 'apiKey',
            'in'   => 'header',
            'name' => 'x-application-version',
        ];
        $components['securitySchemes']['XEncryption'] = [
            'type' => 'apiKey',
            'in'   => 'header',
            'name' => 'x-encryption',
        ];
        $data = [
            'components' => $components
        ] + $data;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }
}

```

### 4. Create Swagger UI View

```
<?php

$webasset = $this->assetManager->getBundle('\developer\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'API Documentation - Swagger';
$this->params['title'] = $this->title;
?>
<link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist/swagger-ui.css" />

<div class="row">
  <div class="col-md-12 mb-3">
    <div id="swagger-ui" class="bg-white"></div>
  </div>
</div>


<script src="https://unpkg.com/swagger-ui-dist/swagger-ui-bundle.js"></script>
<script>
  window.onload = () => {
    const ui = SwaggerUIBundle({
      url: "<?= \yii\helpers\Url::toRoute(['json']) ?>",
      dom_id: "#swagger-ui",
      deepLinking: true,
      presets: [SwaggerUIBundle.presets.apis],
      layout: "BaseLayout",
      persistAuthorization: true,
    });
  };
</script>
```

### 5. Add Entry Point in Site Controller in API folder

```
api\controllers\SiteController.php
```
```
#[OA\Info(
    version: '1.0.0',
    title: 'My API'
)]
class SiteController extends RestController
```

### 6. Sample API Annotation in Controller

```
   /**
     * @OA\Get(
     *     path="/master-meta-info",
     *     tags={"Master"},
     *     summary="Master Meta Last Updated Information",
     *     description="This API is used to retrieve all master tables available in both the mobile app and the web application.<br>When the app launches, it calls this API. Each master table entry contains a last_updated_time field. If the timestamp returned by the API does not match the timestamp stored locally, the corresponding table is synchronized to update records.",
     *     security={
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_meta_table_info",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(
     *                         property="query_params",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                         example={} 
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="name", type="string", example="MasterAirport"),
     *                         @OA\Property(property="total_count", type="integer", example=197),
     *                         @OA\Property(property="last_updated_time", type="string", format="date-time", example="2025-10-30 15:09:44")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Master Meta Info Not Found")
     *         )
     *     )
     * )
     */
```

### 7. Generating Documentation

Swagger JSON will be available at:

```
/api/default/json
```

Swagger UI will be available at:

```
/api
```

### 🎯 Tips for Cleaner Documentation

* Keep schemas in dedicated files (schemas/ModelName.php)

* Use reusable components for responses

* Use @OA\RequestBody for POST payloads

* Always define example values for clarity