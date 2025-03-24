<?php

namespace common\components;

use common\models\moderation\form\ModerationForm;
use common\models\moderation\ImageAlcohol;
use common\models\moderation\ImageBrightness;
use common\models\moderation\ImageColors;
use common\models\moderation\ImageContrast;
use common\models\moderation\ImageDestruction;
use common\models\moderation\ImageFace;
use common\models\moderation\ImageFaces;
use common\models\moderation\ImageGambling;
use common\models\moderation\ImageGore;
use common\models\moderation\ImageMedia;
use common\models\moderation\ImageMedical;
use common\models\moderation\ImageMilitary;
use common\models\moderation\ImageMoney;
use common\models\moderation\ImageNudity;
use common\models\moderation\ImageOffensive;
use common\models\moderation\ImageQuality;
use common\models\moderation\ImageRecreationalDrug;
use common\models\moderation\ImageRequest;
use common\models\moderation\ImageScam;
use common\models\moderation\ImageSelfHarm;
use common\models\moderation\ImageSharpness;
use common\models\moderation\ImageTobacco;
use common\models\moderation\ImageType;
use common\models\moderation\ImageViolence;
use common\models\moderation\ImageWeapon;
use common\models\moderation\ModerationText;
use common\models\moderation\ModerationTextPersonal;
use common\models\moderation\VideoAlcohol;
use common\models\moderation\VideoAudio;
use common\models\moderation\VideoColors;
use common\models\moderation\VideoDestruction;
use common\models\moderation\VideoFace;
use common\models\moderation\VideoGambling;
use common\models\moderation\VideoGore;
use common\models\moderation\VideoImageQualityDetection;
use common\models\moderation\VideoMedical;
use common\models\moderation\VideoMilitary;
use common\models\moderation\VideoMoney;
use common\models\moderation\VideoNudity;
use common\models\moderation\VideoOffensive;
use common\models\moderation\VideoRecreationalDrug;
use common\models\moderation\VideoScam;
use common\models\moderation\VideoSelfharm;
use common\models\moderation\VideoSmoking;
use common\models\moderation\VideoText;
use common\models\moderation\VideoType;
use common\models\moderation\VideoViolence;
use common\models\moderation\VideoWeapon;
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

    public $sights = [
        "689569113" => "YbuJVoxpbSbq88oXokhQ3hsfKhCVsGGX",
        // "460273805" => "AHEYH7qsx2qwTTrwcqtqVFhnkT2e7zPn",
        // "101632135" => "FRrzHTpHk7GBvY86HokP7MV884SbrRHu",
    ];

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
        'gambling',
        'destruction',
        'military',
        // 'audio-profanity','
    ];



    public function imageFeedback($url, $moderationId)
    {
        foreach ($this->sights as $key =>  $sight) {
            try {
                $params = array(
                    'url' =>  $url,
                    'models' => implode(',', $this->models),
                    'api_user' => $key,
                    'api_secret' => $sight,
                );

                // this example uses cURL
                $ch = curl_init('https://api.sightengine.com/1.0/check.json?' . http_build_query($params));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($response, true);
                $this->actionStoreImageFeedback($output, $moderationId);
                return $output;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }

    public function videoFeedback($url, $id)
    {
        foreach ($this->sights as $key =>  $sight) {
            try {
                $params = array(
                    'media' => new CURLFile($url),
                    // specify the models you want to apply
                    'models' => implode(',', $this->models),
                    'api_user' => $key,
                    'api_secret' => $sight,
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
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }


    public function textFeedback($text, $moderationId)
    {
        foreach ($this->sights as $key =>  $sight) {
            try {
                $params = array(
                    'text' => $text,
                    // 'lang' => 'en,fr,it,pt,es,ru,tr',
                    'lang' => 'en',
                    'models' => 'general,self-harm',
                    // 'mode' => 'ml',
                    // 'mode' => 'rules',
                    'mode' => 'rules,ml',
                    'api_user' => $key,
                    'api_secret' => $sight,
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
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }


    public function actionStoreVideoFeedback($feedback, $id)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/video.json");
        // }
        $this->actionVideoStore($feedback, $id);
    }
    public function actionStoreImageFeedback($feedback, $moderationId)
    {
        // if ($feedback == NULL) {

        //     $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/image.json");
        // }
        $this->actionStoreImage($feedback, ModerationForm::MODERATION_TYPE_IMAGE, $moderationId);
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
                    $model->moderation_id = $moderationId;
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
        $nudity_saved = VideoNudity::nuditystore($fb, $id);
        $offensive_saved = VideoOffensive::offensivestore($fb, $id);
        $gore_saved = VideoGore::gorestore($fb, $id);
        $weapon_saved = VideoWeapon::weaponstore($fb, $id);
        $self_harm_saved = VideoSelfharm::selfharmstore($fb, $id);
        $violence_saved = VideoViolence::voilencestore($fb, $id);
        $recreational_saved = VideoRecreationalDrug::recreationaldrugstore($fb, $id);
        $medical_saved = VideoMedical::medicalstore($fb, $id);
        $alcohol_saved = VideoAlcohol::alcoholstore($fb, $id);
        $gambling_saved = VideoGambling::gamblingstore($fb, $id);
        $smoking_saved = VideoSmoking::smokingstore($fb, $id);
        $money_saved = VideoMoney::moneystore($fb, $id);
        $color_saved = VideoColors::colorstore($fb, $id);
        $type_saved = VideoType::typestore($fb, $id);
        $image_quality_saved = VideoImageQualityDetection::imagequalitystore($fb, $id);
        $destruction_saved = VideoDestruction::destructionstore($fb, $id);
        $military_saved = VideoMilitary::militarystore($fb, $id);
        // $audio_saved = VideoAudio::audiostore($fb, $id);
        $text_saved = VideoText::textstore($fb, $id);
        $face_saved = VideoFace::facestore($fb, $id);
        $scam_saved = VideoScam::scamstore($fb, $id);

        if (
            $nudity_saved && $offensive_saved && $gore_saved && $weapon_saved && $self_harm_saved && $violence_saved && $recreational_saved && $medical_saved && $alcohol_saved && $gambling_saved && $smoking_saved && $money_saved
            && $color_saved && $type_saved && $image_quality_saved && $destruction_saved && $military_saved && $text_saved && $face_saved && $scam_saved
        ) {
            echo "Stored Successfully";
        } else {
            exit("Error: Failed to store data");
        }
    }

    private function actionStoreImage($feedback, $moderation_type, $moderationId)
    {
        $alcohol_saved = ImageAlcohol::alcoholStore($feedback, $moderationId);
        $color_saved = ImageColors::colorStore($feedback, $moderationId);
        $destruction_saved = ImageDestruction::destructionStore($feedback, $moderationId);
        $face_saved = ImageFace::faceStore($feedback, $moderationId);
        $gambling_saved = ImageGambling::gamblingStore($feedback, $moderationId);
        $gore_saved = ImageGore::goreStore($feedback, $moderationId);
        $media_saved = ImageMedia::mediaStore($feedback, $moderationId);
        $medical_saved = ImageMedical::medicalStore($feedback, $moderationId);
        $military_saved = ImageMilitary::militaryStore($feedback, $moderationId);
        $money_saved = ImageMoney::moneyStore($feedback, $moderationId);
        $nudity_saved = ImageNudity::nudityStore($feedback, $moderationId);
        $offensive_saved = ImageOffensive::offensiveStore($feedback, $moderationId);
        $quality_saved = ImageQuality::qualityStore($feedback, $moderationId);
        // $recreational_saved = ImageRecreationalDrug::recreationalDrugStore($feedback, $moderationId);
        $request_saved = ImageRequest::requestStore($feedback, $moderationId);
        $scam_saved = ImageScam::scamStore($feedback, $moderationId);
        $self_harm_saved = ImageSelfHarm::selfHarmStore($feedback, $moderationId);
        $tobacco_saved = ImageTobacco::tobaccoStore($feedback, $moderationId);
        $type_saved = ImageType::typeStore($feedback, $moderationId);
        $violence_saved = ImageViolence::voilenceStore($feedback, $moderationId);
        $weapon_saved = ImageWeapon::weaponStore($feedback, $moderationId);
        $brightness_saved = ImageBrightness::brightnessStore($feedback, $moderationId);
        $sharpness_saved = ImageSharpness::sharpnessStore($feedback, $moderationId);
        $contrast_saved = ImageContrast::contrastStore($feedback, $moderationId);

        if (
            $nudity_saved && $offensive_saved && $gore_saved && $weapon_saved && $self_harm_saved && $face_saved && $scam_saved
            && $tobacco_saved && $request_saved && $quality_saved && $violence_saved && $medical_saved && $alcohol_saved
            && $gambling_saved && $money_saved && $color_saved && $type_saved && $destruction_saved && $military_saved
            && $media_saved && $contrast_saved && $sharpness_saved && $brightness_saved
        ) {
            echo "Image Data Stored Successfully";
        } else {
            exit("Error: Failed to store data");
        }
    }
}
