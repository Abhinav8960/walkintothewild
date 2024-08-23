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
    public $website_url;
    public $about;
    public $user_bio;
    public $account_type;
    public $youtube_url;

    public $gender;
    public $date_of_birth;

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
            // $this->whatsapp_url = $this->user_model->whatsapp_url;
            $this->x_url = $this->user_model->x_url;
            $this->insta_url = $this->user_model->insta_url;
            $this->website_url = $this->user_model->website_url;
            $this->youtube_url = $this->user_model->youtube_url;
            $this->about = $this->user_model->about;
            $this->user_bio = $this->user_model->user_bio;
            $this->account_type = $this->user_model->account_type;
            $this->gender = $this->user_model->gender;
            $this->date_of_birth = $this->user_model->date_of_birth;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_handle', 'name'], 'required'],
            ['account_type', 'integer'],
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['user_bio', 'string', 'max' => 120],
            ['mobile_no', 'match', 'pattern' => '/^\+?\d{10,15}$/', 'message' => 'Invalid mobile number format.'],
            [['profile_image', 'cover_image'], 'safe'],

            ['user_handle', function () {
                // Allow Only Small Letter Character(a-z), digit(0-9) and Underscore(_)
                if (!preg_match('/^[a-z0-9_.]*$/', $this->user_handle)) {
                    $this->addError('user_handle', 'Invalid Username!!!');
                }
            }],
            [
                'user_handle',
                'unique',
                'when' => function ($model, $attribute) {
                    return strtolower($this->user_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => User::className(),
                'targetAttribute' => ['user_handle'],
                'message' => 'This username has already been taken'
            ],
            [['facebook_url', 'whatsapp_url', 'x_url', 'insta_url', 'website_url', 'youtube_url'], 'url', 'defaultScheme' => 'https'],
            [['about'], 'string'],

            [
                ['cover_image'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 1024 * 1024 * 2
            ],

            [
                ['profile_image'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 1024 * 1024 * 2
            ],

            ['gender', 'integer'],
            ['date_of_birth', 'safe'],


        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'mobile_no' => 'Mobile Number',
            'profile_image' => 'Profile Picture',
            'cover_image' => 'Cover Image',
            'user_handle' => 'Username',
            'facebook_url' => 'Facebook',
            'whatsapp_url' => 'Whatsapp',
            'x_url' => 'Twitter Link',
            'insta_url' => 'Instagram',
            'about' => 'About',
            'account_type' => 'Account Type',
            'user_bio' => 'You are',
            'gender' => 'Gender',
            'date_of_birth' => 'D.O.B',
            'website_url' => 'Website Url',
            'youtube_url' => 'Youtube Url',

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
        $this->user_model->website_url = $this->website_url;
        $this->user_model->youtube_url = $this->youtube_url;
        $this->user_model->about = $this->about;
        $this->user_model->user_bio = $this->user_bio;
        // $this->user_model->account_type = $this->account_type;
        $this->user_model->gender = $this->gender;
        $this->user_model->date_of_birth = $this->date_of_birth;
    }


    public function uploadFile()
    {

        if ($this->profile_image) {
            $storagePath = Yii::$app->params['datapath'] . '/user';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->user_model->id;

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'user' . time() . '.' . $this->profile_image->extension;

            $filePath = $storagePath . '/' . $fileName;


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
