<?php

namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $name;
    public $mobile_no;
    public $profile_image;
    public $user_model;

    public function __construct($user_model)
    {
        $this->user_model = Yii::createObject([
            'class' => User::className()
        ]);
            $this->user_model = $user_model;
            $this->name = $this->user_model->name;
            $this->mobile_no = $this->user_model->mobile_no;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['mobile_no', 'match', 'pattern' => '/^\+?\d{10,15}$/', 'message' => 'Invalid mobile number format.'],
            [['profile_image'], 'file', 'extensions' => 'png, jpg, jpeg'],


        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'mobile_no' => 'Mobile Number',
            'profile_image' => 'Profile Picture',

        ];
    }

    public function initializeForm()
    {
        $this->user_model->name = $this->name;
        $this->user_model->mobile_no = $this->mobile_no;
    }
    public function uploadFile()
    {

        if ($this->profile_image) {
            $storagePath = Yii::$app->params['datapath'] . '/user';
            // print_r($storagePath);
            // die;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->user_model->id;
            // print_r($storagePath);
            // die;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'user' . time() . '.' . $this->profile_image->extension;
            //print_r($fileName);
            $filePath = $storagePath . '/' . $fileName;
            // print_r($filePath);
            // die;

            if ($this->profile_image->saveAs($filePath)) {
                $this->user_model->profile_image = $fileName;
                $this->user_model->save(false);
            }
        }
    }
}
