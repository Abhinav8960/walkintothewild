<?php

namespace api\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;
use app\components\AttestationValidator;

// Your component to talk to Google/Apple

class AppAttestationFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        $request = Yii::$app->request;
        $platform = $request->headers->get('X-Client-Platform'); // e.g., 'android' or 'ios'
        $attestationToken = null;

        if ($platform === 'android') {
            $attestationToken = $request->headers->get('X-Play-Integrity-Token');
        } elseif ($platform === 'ios') {
            $attestationToken = $request->headers->get('X-App-Attest-Assertion');
            // May need additional data like keyId or clientDataHash depending on flow
        } else {
             throw new UnauthorizedHttpException('Client platform header missing or invalid.');
        }

        if (empty($attestationToken)) {
            throw new UnauthorizedHttpException('Attestation token missing.');
        }

        // Get your validation component/service
        $validator = Yii::$app->get('attestationValidator'); // Assumes component named 'attestationValidator'

        if (!$validator->validate($platform, $attestationToken /*, other necessary data */)) {
             // Log the failure details internally if needed
             Yii::warning("App Attestation Failed for platform: $platform", __METHOD__);
             throw new UnauthorizedHttpException('App attestation failed.');
        }

        // Attestation successful, proceed to next filter or action
        return parent::beforeAction($action);
    }
}
