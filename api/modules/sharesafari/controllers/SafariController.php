<?php

namespace api\modules\sharesafari\controllers;

use Yii;

use api\controllers\RestController;
use api\models\sharesafari\ShareSafari;


/**
 * Site controller
 */
class SafariController extends RestController
{

    public $slug;
    public $sharesafari;

    public function init()
    {
        parent::init();
        $this->slug = \Yii::$app->request->get('slug');
        $this->sharesafari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $this->slug])->limit(1)->one();

        if (!empty($this->slug) && empty($this->sharesafari)) {
            Yii::$app->api->sendFailedStringResponse(['Safari not found']);
        }
    }

    /**
     * @inheritdoc
     */
    protected function isSafariHost()
    {
        if (!empty($this->sharesafari)) {
            if ($this->userinfoId == $this->sharesafari->host_user_id) {
                return false;
            }
        }
        return true;
    }
}
