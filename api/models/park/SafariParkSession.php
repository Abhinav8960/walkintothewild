<?php

namespace api\models\park;

use api\models\meta\MetaSafariSession;
use Yii;

/**
 * This is the model class for table "safari_park_session".
 *
 * @property int $id
 * @property int|null $safari_park_id
 * @property int|null $session_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SafariParkSession extends \common\models\park\SafariParkSession
{
   

    public function getMetasession()
    {
        return $this->hasOne(MetaSafariSession::className(), ['id' => 'session_id']);
    }
}
