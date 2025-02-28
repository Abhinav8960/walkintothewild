<?php

namespace common\components;

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
    private $sightEngineUserId = "101632135";
    private $sightEnginesecretId = "FRrzHTpHk7GBvY86HokP7MV884SbrRHu";
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

        return $output = json_decode($response, true);
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

       return $output = json_decode($response, true);
    }


    public function textFeedback($text)
    {
        $params = array(
            'text' => $text,
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

        return $output = json_decode($response, true);
    }
}
