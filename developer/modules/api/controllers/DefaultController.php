<?php

namespace developer\modules\api\controllers;

use yii;
use yii\web\Response;
use yii\web\Controller;

/**
 * Default controller for the `transactioninfo` module
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
        ]);

        $data = json_decode($openapi->toJson(), true);
        $host = Yii::$app->params['api_url'];

        $data['servers'] = [
            [
                'url' => $host,
                'description' => 'Auto-detected',
            ],
            [
                'url' => 'https://staging-api.walkintothewild.in/',
                'description' => 'Staging Server',
            ],
            [
                'url' => 'https://api.walkintothewild.in/',
                'description' => 'Production Server',
            ],
        ];

        $data['info'] = [
            // 'title' => 'Walk Into The Wild API',
            // 'version' => '1.0.0',
            // 'description' => 'Swagger API documentation for Walk Into The Wild — provides all public and private endpoints.',
            // 'termsOfService' => 'https://walkintothewild.in/terms-of-use',
            // 'contact' => [
            //     'name' => 'Walk Into The Wild Support',
            //     'email' => 'support@walkintothewild.in',
            //     // 'url' => 'https://walkintothewild.in',
            // ],
            // 'license' => [
            //     'name' => 'MIT License',
            //     'url' => 'https://opensource.org/licenses/MIT',
            // ],
        ];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }
}
