<?php

namespace api\models;

use Yii;

class UserPrivacyPolicyAcknowledgement extends \common\models\userprivacypolicyacknowledgement\UserPrivacyPolicyAcknowledgement
{
    public function fields()
    {
        $fields = [
            'id',
            'uuid',
            'user_id',
            'document_version',
            'document_id',
        ];
        return $fields;
    }
}
