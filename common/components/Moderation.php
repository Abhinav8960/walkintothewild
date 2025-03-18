<?php

namespace common\components;

use common\models\moderation\form\ModerationForm;
use common\models\moderation\ModerationText;
use common\models\moderation\ModerationTextPersonal;
use CURLFile;
use DateTimeImmutable;
use Yii;
use yii\base\Component;


/**
 * Class for common API functions
 */
class Moderation extends Component
{
    public $fileUrl;
    // private $sightEngineUserId = "101632135"; // Anurag
    // private $sightEnginesecretId = "FRrzHTpHk7GBvY86HokP7MV884SbrRHu"; // Anurag

    private $sightEngineUserId = "1054537867"; // Kamal
    private $sightEnginesecretId = "HpudaFDnhw8Ki3Ja7yxSPMHXFceWvbP3"; // Kamal
    // public $imageUrl = "https://manage.spidernet.in/images/spiderlogo.png";

    private $models = [
        'nudity-2.1',
        'weapon',
        'alcohol',
        'recreational_drug',
        'medical',
        'properties',
        'type',
        'quality',
        'offensive-2.0',
        'faces',
        'scam',
        'text-content',
        'face-attributes',
        'gore-2.0',
        'text',
        'qr-content',
        'tobacco',
        'genai',
        'violence',
        'self-harm',
        'money',
        'gambling'
    ];



    public function imageFeedback($url)
    {
        $params = array(
            'url' =>  $url,
            'models' => implode(',', $this->models),
            'api_user' => $this->sightEngineUserId,
            'api_secret' => $this->sightEnginesecretId,
        );

        // this example uses cURL
        $ch = curl_init('https://api.sightengine.com/1.0/check.json?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($response, true);
        $this->actionStoreImageFeedback($output);
        return $output;
    }

    public function videoFeedback($url)
    {
        $params = array(
            'media' => new CURLFile($url),
            // specify the models you want to apply
            'models' => implode(',', $this->models),
            'api_user' => $this->sightEngineUserId,
            'api_secret' => $this->sightEnginesecretId,
        );

        // this example uses cURL
        $ch = curl_init('https://api.sightengine.com/1.0/video/check-sync.json');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($response, true);
        $this->actionStoreVideoFeedback($output);
        return $output;
    }


    public function textFeedback($text)
    {
        $params = array(
            'text' => $text,
            // 'lang' => 'en,fr,it,pt,es,ru,tr',
            'lang' => 'en',
            'models' => 'general,self-harm',
            // 'mode' => 'ml',
            // 'mode' => 'rules',
            'mode' => 'rules,ml',
            'api_user' => $this->sightEngineUserId,
            'api_secret' => $this->sightEnginesecretId,
        );

        // this example uses cURL
        $ch = curl_init('https://api.sightengine.com/1.0/text/check.json');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($response, true);
        $this->actionStoreTextFeedback($output);
        return $output;
    }


    public function actionStoreVideoFeedback($feedback)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/video.json");
        // }
        $this->actionStore($feedback, ModerationForm::MODERATION_TYPE_VIDEO);
    }
    public function actionStoreImageFeedback($feedback)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/image.json");
        // }
        $this->actionStore($feedback, ModerationForm::MODERATION_TYPE_IMAGE);
    }
    public function actionStoreTextFeedback($feedback)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/text.json");
        // }
        $this->actionStoreText($feedback, ModerationForm::MODERATION_TYPE_TEXT);
    }

    private function actionStoreText($feedback, $moderation_type)
    {
        $model = new ModerationText();
        $model->request_id = $feedback['request']['id'];
        $model->request_timestamp = $feedback['request']['timestamp'];

        $model->sexual = $feedback['moderation_classes']['sexual'];
        $model->discriminatory = $feedback['moderation_classes']['discriminatory'];
        $model->insulting = $feedback['moderation_classes']['insulting'];
        $model->violent = $feedback['moderation_classes']['violent'];
        $model->toxic = $feedback['moderation_classes']['toxic'];
        $model->self_harm = $feedback['moderation_classes']['self-harm'];

        $model->moderation_type = $moderation_type;
        // $model->feedback = $feedback;
        // $model->status = 1;
        if ($model->save(false)) {
            if (!empty($feedback['personal']['matches'])) {
                foreach ($feedback['personal']['matches'] as $match) {
                    $modelTextPersonal = new ModerationTextPersonal();
                    $modelTextPersonal->moderation_text_id = $model->id;
                    $modelTextPersonal->type = $match['type'];
                    $modelTextPersonal->match = $match['match'];
                    $modelTextPersonal->start = $match['start'];
                    $modelTextPersonal->end = $match['end'];
                    $modelTextPersonal->save(false);
                }
            }

            if (!empty($feedback['link']['matches'])) {
                foreach ($feedback['link']['matches'] as $match) {
                    $modelTextPersonal = new ModerationTextPersonal();
                    $modelTextPersonal->moderation_text_id = $model->id;
                    $modelTextPersonal->type = $match['type'];
                    $modelTextPersonal->category = $match['category'];
                    $modelTextPersonal->match = $match['match'];
                    $modelTextPersonal->start = $match['start'];
                    $modelTextPersonal->end = $match['end'];
                    $modelTextPersonal->save(false);
                }
            }

            echo "Feedback Stored Successfully";
            die;
        } else {
            exit("Error: " . json_encode($model->errors));
        }
    }
}
