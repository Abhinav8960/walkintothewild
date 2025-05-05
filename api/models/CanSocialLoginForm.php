<?php

namespace api\models;

use common\models\Auth;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class CanSocialLoginForm extends Model
{
    public $source_id;
    public $source;

    /**
     * {@inheritdoc}
     */
    
    public function rules()
    {
        return [
            // username and password are both required
            [['source_id', 'source'], 'required'],
        ];
    }

    public function can_login()
    {
        $auth = Auth::find()->where(['source' => $this->source, 'source_id' => $this->source_id])->one();
        if (!empty($auth)) {
            return true;
        }
        return false;
    }
}
