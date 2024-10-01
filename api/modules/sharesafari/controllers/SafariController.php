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

    public $sharesafari_id;
    public $sharesafari;

    public function init()
    {
        parent::init();
        $this->sharesafari_id = \Yii::$app->request->get('sharesafari_id');
        $this->sharesafari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'id' =>  $this->sharesafari_id])->limit(1)->one();

       
    }

    /**
     * @inheritdoc
     */
    private function isSafariHost()
    {

        if($this->userinfoId == $this->sharesafari->host_user_id){
            return false;
        }
        return true;

    }
}
