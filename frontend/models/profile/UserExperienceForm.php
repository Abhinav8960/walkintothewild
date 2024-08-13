<?php

namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use common\models\UserExperience;

/**
 * UserExperienceForm form
 */
class UserExperienceForm extends Model
{
    public $id;
    public $file;
    public $description;
    public $user_id;
    public $park_id;
    public $user_experience_model;
    public $action_url;
    public $action_validate_url;
    public $status;
    public $parks;

    public function __construct(UserExperience $user_experience_model = null)
    {
        $this->user_experience_model = Yii::createObject([
            'class' => UserExperience::className()
        ]);
        // if ($user_experience_model != null) {
        //     $this->user_experience_model = $user_experience_model;
        //     $this->file = $this->user_experience_model->file;
        //     $this->description = $this->user_experience_model->description;
        //     $this->user_id = $this->user_experience_model->user_id;
        //     $this->park_id = $this->user_experience_model->park_id;
        //     $this->status = $this->user_experience_model->status;
        // }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['description'], 'required'],
            // [['file'], 'safe'],
            // [
            //     ['file'],
            //     'image',
            //     'extensions' => ['jpeg', 'jpg', 'png'],
            //     'maxSize' => 250 * 1024
            // ],
            // [['user_id', 'park_id', 'status'], 'integer'],
            // [['description'], 'string'],

            ['parks', 'safe']


        ];
    }

    // public function attributeLabels()
    // {
    //     return [
    //         'user_id' => 'User',
    //         'park_id' => 'Type Of Park',
    //         'file' => 'File',
    //         'description' => 'Description',
    //         'status' => 'Status',
    //     ];
    // }

    // public function initializeForm()
    // {
    //     $this->user_experience_model->user_id = $this->user_id;
    //     $this->user_experience_model->park_id = $this->park_id;
    //     $this->user_experience_model->description = $this->description;
    //     $this->user_experience_model->status = $this->status;
    // }


    // public function uploadFile()
    // {

    //     if ($this->file) {
    //         $storagePath = Yii::$app->params['datapath'] . '/userpost';

    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath);
    //             chmod($storagePath, 0777);
    //         }
    //         $storagePath = $storagePath . '/' . $this->user_experience_model->id;

    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath);
    //             chmod($storagePath, 0777);
    //         }

    //         $fileName = 'user' . time() . '.' . $this->file->extension;

    //         $filePath = $storagePath . '/' . $fileName;


    //         if ($this->file->saveAs($filePath)) {
    //             $this->user_experience_model->file = $fileName;
    //             $this->user_experience_model->save(false);
    //         }
    //     }
    // }
}
