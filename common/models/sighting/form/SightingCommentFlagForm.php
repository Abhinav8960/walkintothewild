<?php

namespace common\models\sighting\form;

use common\models\cms\flagreason\Flagreason;
use common\models\sighting\SightingCommentFlag;
use Yii;
use yii\base\Model;

/**
 * SightingCommentFlagForm is the model behind the SightingCommentFlagForm form.
 */
class SightingCommentFlagForm extends Model
{
    public $sighting_id;
    public $sighting_comment_id;
    public $flag_reason_id;
    public $flag_detail;
    public $status;
    public $sighting_flag_model;


    public function __construct(SightingCommentFlag $sighting_flag_model = null)
    {
        $this->sighting_flag_model = Yii::createObject([
            'class' => SightingCommentFlag::className()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_reason_id', 'flag_detail'], 'required'],
            ['flag_reason_id', 'exist', 'targetClass' => Flagreason::class, 'targetAttribute' => ['flag_reason_id' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sighting_id' => 'Sighting ID',
            'sighting_comment_id' => 'Sighting Comment ID',
            'flag_reason_id' => 'Flag Reason ID',
            'flag_detail' => 'Flag Detail',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }


    public function initializeForm()
    {

        $this->sighting_flag_model->user_id = Yii::$app->user->identity->id;
        $this->sighting_flag_model->sighting_id = $this->sighting_id;
        $this->sighting_flag_model->sighting_comment_id = $this->sighting_comment_id;
        $this->sighting_flag_model->flag_reason_id = $this->flag_reason_id;
        $this->sighting_flag_model->flag_detail = $this->flag_detail;
        $this->sighting_flag_model->status = 1;
    }
}
