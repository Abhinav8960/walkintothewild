<?php

namespace common\models;

use yii\httpclient\Client;

class WhatsappHelper
{
    // 100438186238134


    const AUTHORIZATION_CODE = "EAAL9A2Fd7ZCABOZB9zCGbwTEppzl4lQMvNVdsqDUJ2lsZCfGlJryYAZCAyENvoFMChHumfXTMv7OExf71zCh4ZBRFudTkeG45J6ufnIFRDjG35fiPkB1lA0Q2E8DGLEtnllmIYnSYR4OXBZBtSLiDxnJd7XsvvlPtquVfVKcKZBf9vZBxz0JAqcZBiW7uj0KqAGEGSjaNCQPgLfVYWLQu";
    // const AUTHORIZATION_CODE = "EAAL9A2Fd7ZCABOZB9zCGbwTEppzl4lQMvNVdsqDUJ2lsZCfGlJryYAZCAyENvoFMChHumfXTMv7OExf71zCh4ZBRFudTkeG45J6ufnIFRDjG35fiPkB1lA0Q2E8DGLEtnllmIYnSYR4OXBZBtSLiDxnJd7XsvvlPtquVfVKcKZBf9vZBxz0JAqcZBiW7uj0KqAGEGSjaNCQPgLfVYWLQu";
    const WHATSAPP_TEMPLATE_NAME  = "project_error_report";
    const WHATSAPP_REQUEST_URL  = "https://graph.facebook.com/v17.0/100438186238134/messages";

    public static function SendDataUsingWithTemplateSurvey($phone, $case_id)
    {
        $raw_request_json =
            [
                'messaging_product' => "whatsapp",
                "to" => $phone,
                "type" => "template",
                "template" => [
                    "name" => 'conv_surveycto_pre_tipping_point_caseid',
                    "language" => [
                        "code" => "en"
                    ],
                    "components" => [
                        [
                            "type" => "button",
                            "sub_type" => "url",
                            "index" => 0,
                            "parameters" => [
                                [
                                    "type" => "text",
                                    "text" => $case_id
                                ]

                            ]
                        ],



                    ]
                ]
            ];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::WHATSAPP_REQUEST_URL)
            ->addHeaders([
                'Authorization' => 'Bearer ' . self::AUTHORIZATION_CODE,
                'Content-Type' => 'application/json',
            ])
            ->setContent(json_encode($raw_request_json))
            ->send();

        // \Yii::warning([$phone, $case_id, $response], 'convergent');
        self::logMe($phone, $case_id, $response);
        return $response;
    }

    public static function logMe($phone, $case_id, $response)
    {
        $model = new ConvergentLog();

        $model->timestamp = date('Y-m-d H:i:s');
        $model->phone = $phone;
        $model->case_id = $case_id;
        $model->response = $response;


        $model->save(false);
        return true;
    }
}
