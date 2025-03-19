<?php

namespace common\models\moderation;

use Yii;
use yii\helpers\Html;

class Moderation extends \common\models\moderation\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moderation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['type'], 'required'],
            [['type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['text'], 'string'],
            [['video_url', 'image_url'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'video_url' => 'Video Url',
            'image_url' => 'Image Url',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getModerationText()
    {
        return $this->hasOne(ModerationText::className(), ['moderation_id' => 'id']);
    }


    public function getTags()
    {
        $moderation_models = [
            ['class' => 'common\models\moderation\Nudity', 'title' => 'Nudity'],
            ['class' => 'common\models\moderation\Offensive', 'title' => 'Offensive'],
            ['class' => 'common\models\moderation\Money', 'title' => 'Money'],
            ['class' => 'common\models\moderation\VideoDestruction', 'title' => 'Destruction'],
            ['class' => 'common\models\moderation\VideoMilitary', 'title' => 'Military'],
            // ['class' => 'common\models\moderation\VideoAudioProfanity', 'title' => 'Audio Profanity'],
        ];
        $str = "";
        if ($this->type == 2) {
            foreach ($moderation_models as $moderation_models_data) {
                $class_name = $moderation_models_data['class'];
                $attributes = $class_name::$accessible_attributes;
                $selectExpressions = [];
                foreach ($attributes as $attribute) {
                    $selectExpressions[] = new \yii\db\Expression("MAX({$attribute}) AS {$attribute}");
                }
                $maxValues = $class_name::find()
                    ->select($selectExpressions)
                    ->where(['moderation_id' => $this->id])
                    ->asArray()
                    ->one();
                $sub_str = "";
                if (!empty($maxValues)) {
                    $sub_str .= "<h3>" . $moderation_models_data['title'] . "</h3>";
                    foreach ($maxValues as $attribute => $value) {
                        $percentage_val = $value * 100;
                        $label = ucfirst(str_replace('_', ' ', $attribute));
                        $sub_str .= "<span class='badge' style='background-color: " . ($percentage_val >= 40 ? "#dc3545" : "#007bff") . "; color: white; padding: 5px 10px; margin: 2px; border-radius: 5px;'>"
                            . $label . " :" . "" . $percentage_val .  "<span>&#37;</span></span>";
                    }
                }
                $str .= $sub_str;
            }
        }
        return $str;
    }

    public function getModerationTextDetails()
    {
        $textDetail = [];

        $createBadge = function ($label, $value) {
            $class = $value > 40 ? 'badge text-bg-danger' : 'badge text-bg-primary';
            return Html::tag('span', "$label $value%", ['class' => $class, 'style' => 'padding: 5px 10px; margin: 2px;']);
        };

        $textData = [
            $createBadge('Sexual', ($this->moderationText->sexual ?? null) * 100),
            $createBadge('Discriminatory', ($this->moderationText->discriminatory ?? null) * 100),
            $createBadge('Insulting', ($this->moderationText->insulting ?? null) * 100),
            $createBadge('Violent', ($this->moderationText->violent ?? null) * 100),
            $createBadge('Toxic', ($this->moderationText->toxic ?? null) * 100),
            $createBadge('Self Harm', ($this->moderationText->self_harm ?? null) * 100)
        ];

        $textDetail[] = implode(' ', $textData);

        if (!empty($this->moderationText->moderationTextPersonal)) {
            $textPersonalData = [];

            foreach ($this->moderationText->moderationTextPersonal as $personal) {
                $info = '';

                if ($personal->is_personal == 1) {
                    $info .= '<strong>PERSONAL</strong> | ';
                }
                if ($personal->is_link == 1) {
                    $info .= '<strong>LINK</strong> | ';
                }

                $info .= "<strong>Type:</strong> " . ($personal->type ?? 'N/A') .
                    " | <strong>Category:</strong> " . ($personal->category ?? 'N/A') .
                    " | <strong>Match:</strong> " . ($personal->match ?? 'N/A') .
                    " | <strong>Start:</strong> " . ($personal->start ?? 'N/A') .
                    " | <strong>End:</strong> " . ($personal->end ?? 'N/A');

                $textPersonalData[] = $info;
            }

            $textDetail[] = "<br>" . implode("<br>", $textPersonalData);
        }

        return implode("<br>", $textDetail);
    }
}
