<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * UserDeleteRequestForm
 */
class UserDeleteRequestForm extends Model
{
    public $user_delete_request;
    public $email;
    public $user_id;

    public function __construct(UserDeleteRequest $user_delete_request = null)
    {
        $this->user_delete_request = Yii::createObject([
            'class' => UserDeleteRequest::className()
        ]);

        if ($user_delete_request != null) {
            $this->user_delete_request = $user_delete_request;
            $this->user_id = $this->user_delete_request->user_id;
            $this->email = $this->user_delete_request->email;
        }
    }


    /** @inheritdoc */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['email'], 'required'],
            [['email'],'email'],
        ];
    }

    /**
     *  @inheritdoc 
     * */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'email' => 'Email',
        ];
    }

    /**
     * initialize Form Data
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->user_delete_request->email = $this->email;
        if ($user = User::find()->where(['email' => $this->email])->limit(1)->one()) {
            $this->user_delete_request->user_id = $user->id;
        }
    }
}
