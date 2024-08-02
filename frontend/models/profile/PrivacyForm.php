<?php

namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * @property User $user
 */
class PrivacyForm extends Model
{

    public $gender_privacy;
    public $email_privacy;
    public $photo_privacy;
    public $contribution_privacy;

    public $user_model;

    public function __construct(User $user_model = null)
    {
        $this->user_model = Yii::createObject([
            'class' => User::className()
        ]);
        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->gender_privacy = $this->user_model->gender_privacy;
            $this->email_privacy = $this->user_model->email_privacy;
            $this->photo_privacy = $this->user_model->photo_privacy;
            $this->contribution_privacy = $this->user_model->contribution_privacy;
        }
    }

    public function rules()
    {
        return [
            [['gender_privacy', 'email_privacy', 'photo_privacy', 'contribution_privacy'], 'integer'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'gender_privacy' => 'Gender',
            'email_privacy' => 'Email',
            'photo_privacy' => 'Photo',
            'contribution_privacy' => 'Contribution',

        ];
    }

    public function initializeForm()
    {
        $this->user_model->gender_privacy = $this->gender_privacy;
        $this->user_model->email_privacy = $this->email_privacy;
        $this->user_model->photo_privacy = $this->photo_privacy;
        $this->user_model->contribution_privacy = $this->contribution_privacy;
    }
}
