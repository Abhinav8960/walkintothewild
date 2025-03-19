<?php

namespace common\components;

use common\models\moderation\Alcohol;
use common\models\moderation\Colors;
use common\models\moderation\form\ModerationForm;
use common\models\moderation\Gambling;
use common\models\moderation\Gore;
use common\models\moderation\Medical;
use common\models\moderation\ModerationText;
use common\models\moderation\ModerationTextPersonal;
use common\models\moderation\Money;
use common\models\moderation\Nudity;
use common\models\moderation\Offensive;
use common\models\moderation\RecreationalDrug;
use common\models\moderation\Selfharm;
use common\models\moderation\Smoking;
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

    // private $sightEngineUserId = "1054537867"; // Kamal
    // private $sightEnginesecretId = "HpudaFDnhw8Ki3Ja7yxSPMHXFceWvbP3"; // Kamal

    // public $imageUrl = "https://manage.spidernet.in/images/spiderlogo.png";

    private $sightEngineUserId = "689569113"; // Akash
    private $sightEnginesecretId = "YbuJVoxpbSbq88oXokhQ3hsfKhCVsGGX"; // Akash


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


    public function textFeedback($text, $moderationId)
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
        $this->actionStoreTextFeedback($output, $moderationId);
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
    public function actionStoreTextFeedback($feedback, $moderationId)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/text.json");
        // }
        $this->actionStoreText($feedback, ModerationForm::MODERATION_TYPE_TEXT, $moderationId);
    }

    private function actionStoreText($feedback, $moderation_type, $moderationId)
    {
        $model = new ModerationText();
        $model->moderation_id = $moderationId;
        $model->request_id = $feedback['request']['id'] ?? NULL;
        $model->request_timestamp = $feedback['request']['timestamp'] ?? NULL;
        $model->sexual = $feedback['moderation_classes']['sexual'] ?? 0;
        $model->discriminatory = $feedback['moderation_classes']['discriminatory'] ?? 0;
        $model->insulting = $feedback['moderation_classes']['insulting'] ?? 0;
        $model->violent = $feedback['moderation_classes']['violent'] ?? 0;
        $model->toxic = $feedback['moderation_classes']['toxic'] ?? 0;
        $model->self_harm = $feedback['moderation_classes']['self-harm'] ?? 0;

        if (!empty($feedback['personal']['matches'])) {
            $model->personal = 1;
        } else {
            $model->personal = 0;
        }
        if (!empty($feedback['link']['matches'])) {
            $model->link = 1;
        } else {
            $model->link = 0;
        }

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
                    $modelTextPersonal->moderation_text_id = $modelTextPersonal->id;
                    $modelTextPersonal->type = $match['type'] ?? NULL;
                    $modelTextPersonal->category = $match['category'] ?? NULL;
                    $modelTextPersonal->match = $match['match'] ?? NULL;
                    $modelTextPersonal->start = $match['start'] ?? NULL;
                    $modelTextPersonal->end = $match['end'] ?? NULL;
                    $modelTextPersonal->save(false);
                }
            }

            echo "Text Feedback Stored Successfully";
            // die;
        } else {
            exit("Error: " . json_encode($model->errors));
        }
    }


    private function actionVideoStore($feedback, $id)
    {

        // $fb = json_decode($feedback, true);
        $fb = $feedback;
        $nudity_saved = Nudity::nuditystore($fb, $id);
        $offensive_saved = Offensive::offensivestore($fb, $id);
        $gore_saved = Gore::gorestore($fb, $id);
        $weapon_saved = Weapon::weaponstore($fb, $id);
        $self_harm_saved = Selfharm::selfharmstore($fb, $id);
        $violence_saved = Violence::voilencestore($fb, $id);
        $recreational_saved = RecreationalDrug::recreationaldrugstore($fb, $id);
        $medical_saved = Medical::medicalstore($fb, $id);
        $alcohol_saved = Alcohol::alcoholstore($fb, $id);
        $gambling_saved = Gambling::gamblingstore($fb, $id);
        $smoking_saved = Smoking::smokingstore($fb, $id);
        $money_saved = Money::moneystore($fb, $id);
        $color_saved = Colors::colorstore($fb, $id);

        if (
            $nudity_saved && $offensive_saved && $gore_saved && $weapon_saved && $self_harm_saved && $violence_saved && $recreational_saved && $medical_saved && $alcohol_saved && $gambling_saved && $smoking_saved && $money_saved
            && $color_saved
        ) {
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
