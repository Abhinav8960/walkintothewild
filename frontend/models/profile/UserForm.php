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
    public $id;
    public $name;
    public $mobile_no;
    public $profile_image;
    public $cover_image;
    public $user_model;
    public $user_handle;
    public $facebook_url;
    public $whatsapp_url;
    public $x_url;
    public $insta_url;
    public $about;

    public function __construct(User $user_model = null)
    {
        $this->user_model = Yii::createObject([
            'class' => User::className()
        ]);
        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->name = $this->user_model->name;
            $this->user_handle = $this->user_model->user_handle;
            $this->mobile_no = $this->user_model->mobile_no;
            $this->facebook_url = $this->user_model->facebook_url;
            $this->whatsapp_url = $this->user_model->whatsapp_url;
            $this->x_url = $this->user_model->x_url;
            $this->insta_url = $this->user_model->insta_url;
            $this->about = $this->user_model->about;
        }
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
            [['profile_image', 'cover_image'], 'safe'],
            ['user_handle', 'safe'],
            [
                'user_handle', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->user_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => User::className(), 'targetAttribute' => ['id', 'user_handle'],
                'message' => 'This username has already been taken'
            ],
            [['facebook_url', 'whatsapp_url', 'x_url', 'insta_url'], 'string'],
            [['about'], 'string'],

            [
                ['cover_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 250 * 1024
            ],

            [
                ['profile_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 250 * 1024
            ],


        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'mobile_no' => 'Mobile Number',
            'profile_image' => 'Profile Picture',
            'cover_image' => 'Cover Image',
            'user_handle' => 'User Handle',
            'facebook_url' => 'Facebook',
            'whatsapp_url' => 'Whatsapp',
            'x_url' => 'Twitter Link',
            'insta_url' => 'Instagram',
            'about' => 'About',

        ];
    }

    public function initializeForm()
    {
        $this->user_model->name = $this->name;
        $this->user_model->mobile_no = $this->mobile_no;
        $this->user_model->user_handle = $this->user_handle;
        $this->user_model->facebook_url = $this->facebook_url;
        $this->user_model->whatsapp_url = $this->whatsapp_url;
        $this->user_model->x_url = $this->x_url;
        $this->user_model->insta_url = $this->insta_url;
        $this->user_model->about = $this->about;
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

        if ($this->cover_image) {
            $storagePath = Yii::$app->params['datapath'] . '/user_cover_image';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->user_model->id;

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'user_cover_image' . time() . '.' . $this->cover_image->extension;
            $filePath = $storagePath . '/' . $fileName;


            if ($this->cover_image->saveAs($filePath)) {
                $this->user_model->cover_image = $fileName;
                $this->user_model->save(false);
            }
        }
    }
}
