<?php

namespace common\components;

use common\models\moderation\form\ModerationForm;
use common\models\moderation\Gore;
use common\models\moderation\ModerationText;
use common\models\moderation\ModerationTextPersonal;
use common\models\moderation\Nudity;
use common\models\moderation\Offensive;
use common\models\moderation\Selfharm;
use common\models\moderation\Violence;
use common\models\moderation\Weapon;
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

    public function videoFeedback($url, $id)
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
        $this->actionStoreVideoFeedback($output, $id);
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


    public function actionStoreVideoFeedback($feedback, $id)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/video.json");
        // }
        $this->actionVideoStore($feedback, $id);
    }
    public function actionStoreImageFeedback($feedback)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/image.json");
        // }
        $this->actionStoreImage($feedback, ModerationForm::MODERATION_TYPE_IMAGE);
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
        $model->request_id = $feedback['request']['id'] ?? NULL;
        $model->request_timestamp = $feedback['request']['timestamp'] ?? NULL;
        $model->sexual = $feedback['moderation_classes']['sexual'] ?? 0;
        $model->discriminatory = $feedback['moderation_classes']['discriminatory'] ?? 0;
        $model->insulting = $feedback['moderation_classes']['insulting'] ?? 0;
        $model->violent = $feedback['moderation_classes']['violent'] ?? 0;
        $model->toxic = $feedback['moderation_classes']['toxic'] ?? 0;
        $model->self_harm = $feedback['moderation_classes']['self-harm'] ?? 0;

        $model->moderation_type = $moderation_type;
        if ($model->save(false)) {
            if (!empty($feedback['personal']['matches'])) {
                foreach ($feedback['personal']['matches'] as $match) {
                    $modelTextPersonal = new ModerationTextPersonal();
                    $modelTextPersonal->moderation_text_id = $model->id;
                    $modelTextPersonal->type = $match['type'] ?? NULL;
                    $modelTextPersonal->match = $match['match'] ?? NULL;
                    $modelTextPersonal->start = $match['start'] ?? NULL;
                    $modelTextPersonal->end = $match['end'] ?? NULL;
                    $modelTextPersonal->save(false);
                }
            }

            if (!empty($feedback['link']['matches'])) {
                foreach ($feedback['link']['matches'] as $match) {
                    $modelTextPersonal = new ModerationTextPersonal();
                    $modelTextPersonal->moderation_text_id = $model->id;
                    $modelTextPersonal->type = $match['type'] ?? NULL;
                    $modelTextPersonal->category = $match['category'] ?? NULL;
                    $modelTextPersonal->match = $match['match'] ?? NULL;
                    $modelTextPersonal->start = $match['start'] ?? NULL;
                    $modelTextPersonal->end = $match['end'] ?? NULL;
                    $modelTextPersonal->save(false);
                }
            }

            echo "Text Feedback Stored Successfully";
            die;
        } else {
            exit("Error: " . json_encode($model->errors));
        }
    }


    private function actionVideoStore($feedback, $id)
    {

        // $fb = json_decode($feedback, true);
        $fb = $feedback;
        $nudity_model = new Nudity();
        $offensive_model = new Offensive();
        $gore_model = new Gore();
        $weapon_model = new Weapon();
        $self_harm_model = new Selfharm();
        $violence_model = new Violence();

        $nudity_saved = $nudity_model->nuditystore($fb, $id);
        $offensive_saved = $offensive_model->offensivestore($fb, $id);
        $gore_saved = $gore_model->gorestore($fb, $id);
        $weapon_saved = $weapon_model->weaponstore($fb, $id);
        $self_harm_saved = $self_harm_model->selfharmstore($fb, $id);
        $violence_saved = $violence_model->voilencestore($fb, $id);

        if ($nudity_saved && $offensive_saved && $gore_saved && $weapon_saved &&  $self_harm_saved && $violence_saved) {
            echo "Stored Successfully";
        } else {
            exit("Error: Failed to store data");
        }
    }

    private function actionStoreImage($feedback, $moderation_type)
    {
        die('actionStoreImage');
    }
}
