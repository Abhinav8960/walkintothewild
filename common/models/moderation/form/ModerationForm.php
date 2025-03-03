<?php

namespace common\models\moderation\form;

use common\models\moderation\Moderation;
use common\models\moderation\ModerationImage;
use common\models\moderation\ModerationText;
use common\models\moderation\ModerationTextPersonal;
use common\models\moderation\ModerationVideoFrames;
use Yii;
use yii\base\Model;


/**
 * Class ModerationForm
 * @package common\models\cms\about\form
 *
 * Handles the creation and updating of About models
 */
class ModerationForm extends Model
{
    const MODERATION_TYPE_IMAGE = 'image';
    const MODERATION_TYPE_VIDEO = 'video';
    const MODERATION_TYPE_TEXT = 'text';
    const DEFAULT_VALUE = 0.00;

    public $request_id;
    public $request_timestamp;
    public $moderation_type;
    public $status;
    public $feedback;
    public $video_frames_feedback;
    public $text_feedback;
    public $image_feedback;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'request_timestamp', 'moderation_type', 'feedback'], 'required'],
            [['request_id', 'moderation_type', 'request_timestamp'], 'string', 'max' => 255],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $moderation = new Moderation();
        $moderation->request_id = $this->request_id;
        $moderation->request_timestamp = $this->request_timestamp;
        $moderation->moderation_type = $this->moderation_type;
        $moderation->status = $this->status;
        if ($moderation->save(false)) {
            try {
                if ($moderation->moderation_type == SELF::MODERATION_TYPE_IMAGE) {
                    $this->updateImageFeedback($moderation->id, $this->feedback);
                } elseif ($moderation->moderation_type == SELF::MODERATION_TYPE_VIDEO) {
                    $this->updateVideoFramesFeedback($moderation->id, $this->feedback);
                } elseif ($moderation->moderation_type == SELF::MODERATION_TYPE_TEXT) {
                    $this->updateTextFeedback($moderation->id, $this->feedback);
                }
            } catch (\Exception $e) {
                \Yii::error("Error saving moderation feedback: " . $e->getMessage());
                print_r($e->getMessage());
                die();
                return false;
            }
        } else {
            \Yii::error("Error saving moderation: " . json_encode($moderation->getErrors()));
            return false;
        }
        return true;
    }

    private function updateVideoFramesFeedback($moderation_id, $video_frames_feedbacks)
    {
        
        if (count($video_frames_feedbacks) > 0) {
            foreach ($video_frames_feedbacks['data']['frames'] as  $feedback) {
               
                $model = new ModerationVideoFrames();
                $model->moderation_id = $moderation_id;
                $model->frames_info_id = $feedback['info']['id'] ?? SELF::DEFAULT_VALUE;
                $model->frames_info_position = $feedback['info']['position'] ?? SELF::DEFAULT_VALUE;
                $model->sexual_activity = $feedback['nudity']['sexual_activity'] ?? SELF::DEFAULT_VALUE;
                $model->sexual_display = $feedback['nudity']['sexual_display'] ?? SELF::DEFAULT_VALUE;
                $model->erotica = $feedback['nudity']['erotica'] ?? SELF::DEFAULT_VALUE;
                $model->very_suggestive = $feedback['nudity']['very_suggestive'] ?? SELF::DEFAULT_VALUE;
                $model->suggestive = $feedback['nudity']['suggestive'] ?? SELF::DEFAULT_VALUE;
                $model->mildly_suggestive = $feedback['nudity']['mildly_suggestive'] ?? SELF::DEFAULT_VALUE;
                $model->bikini = $feedback['nudity']['suggestive_classes']['bikini'] ?? SELF::DEFAULT_VALUE;
                $model->cleavage = $feedback['nudity']['suggestive_classes']['cleavage'] ?? SELF::DEFAULT_VALUE;
                $model->cleavage_very_revealing = $feedback['nudity']['suggestive_classes']['cleavage_categories']['very_revealing'] ?? SELF::DEFAULT_VALUE;
                $model->cleavage_revealing = $feedback['nudity']['suggestive_classes']['cleavage_categories']['revealing'] ?? SELF::DEFAULT_VALUE;
                $model->lingerie = $feedback['nudity']['suggestive_classes']['lingerie'] ?? SELF::DEFAULT_VALUE;
                $model->male_chest = $feedback['nudity']['suggestive_classes']['male_chest'] ?? SELF::DEFAULT_VALUE;
                $model->male_chest_very_revealing = $feedback['nudity']['suggestive_classes']['male_chest_categories']['very_revealing'] ?? SELF::DEFAULT_VALUE;
                $model->male_chest_revealing = $feedback['nudity']['suggestive_classes']['male_chest_categories']['revealing'] ?? SELF::DEFAULT_VALUE;
                $model->male_chest_slightly_revealing = $feedback['nudity']['suggestive_classes']['male_chest_categories']['slightly_revealing'] ?? SELF::DEFAULT_VALUE;
                $model->male_underwear = $feedback['nudity']['suggestive_classes']['male_underwear'] ?? SELF::DEFAULT_VALUE;
                $model->miniskirt = $feedback['nudity']['suggestive_classes']['miniskirt'] ?? SELF::DEFAULT_VALUE;
                $model->minishort = $feedback['nudity']['suggestive_classes']['minishort'] ?? SELF::DEFAULT_VALUE;
                $model->nudity_art = $feedback['nudity']['suggestive_classes']['nudity_art'] ?? SELF::DEFAULT_VALUE;
                $model->schematic = $feedback['nudity']['suggestive_classes']['schematic'] ?? SELF::DEFAULT_VALUE;
                $model->sextoy = $feedback['nudity']['suggestive_classes']['sextoy'] ?? SELF::DEFAULT_VALUE;
                $model->suggestive_focus = $feedback['nudity']['suggestive_classes']['suggestive_focus'] ?? SELF::DEFAULT_VALUE;
                $model->suggestive_pose = $feedback['nudity']['suggestive_classes']['suggestive_pose'] ?? SELF::DEFAULT_VALUE;
                $model->swimwear_male = $feedback['nudity']['suggestive_classes']['swimwear_male'] ?? SELF::DEFAULT_VALUE;
                $model->swimwear_one_piece = $feedback['nudity']['suggestive_classes']['swimwear_one_piece'] ?? SELF::DEFAULT_VALUE;
                $model->visibly_undressed = $feedback['nudity']['suggestive_classes']['visibly_undressed'] ?? SELF::DEFAULT_VALUE;
                $model->context_sea_lake_pool = $feedback['nudity']['context']['sea_lake_pool'] ?? SELF::DEFAULT_VALUE;
                $model->context_outdoor_other = $feedback['nudity']['context']['outdoor_other'] ?? SELF::DEFAULT_VALUE;
                $model->context_indoor_other = $feedback['nudity']['context']['indoor_other'] ?? SELF::DEFAULT_VALUE;
                $model->alcohol = $feedback['alcohol']['prob'] ?? SELF::DEFAULT_VALUE;
                $model->type_photo = $feedback['type']['photo'] ?? SELF::DEFAULT_VALUE;
                $model->type_illustration = $feedback['type']['illustration'] ?? SELF::DEFAULT_VALUE;
                $model->type_ai_generated = $feedback['type']['ai_generated'] ?? SELF::DEFAULT_VALUE;
                $model->offensive_nazi = $feedback['offensive']['nazi'] ?? SELF::DEFAULT_VALUE;
                $model->offensive_asian_swastika = $feedback['offensive']['asian_swastika'] ?? SELF::DEFAULT_VALUE;
                $model->offensive_confederate = $feedback['offensive']['confederate'] ?? SELF::DEFAULT_VALUE;
                $model->offensive_supremacist = $feedback['offensive']['supremacist'] ?? SELF::DEFAULT_VALUE;
                $model->offensive_terrorist = $feedback['offensive']['terrorist'] ?? SELF::DEFAULT_VALUE;
                $model->offensive_middle_finger = $feedback['offensive']['middle_finger'] ?? SELF::DEFAULT_VALUE;
                $model->very_bloody = $feedback['violence']['very_bloody'] ?? SELF::DEFAULT_VALUE;
                $model->slightly_bloody = $feedback['violence']['slightly_bloody'] ?? SELF::DEFAULT_VALUE;
                $model->body_organ = $feedback['violence']['body_organ'] ?? SELF::DEFAULT_VALUE;
                $model->serious_injury = $feedback['violence']['serious_injury'] ?? SELF::DEFAULT_VALUE;
                $model->superficial_injury = $feedback['violence']['superficial_injury'] ?? SELF::DEFAULT_VALUE;
                $model->corpse = $feedback['violence']['corpse'] ?? SELF::DEFAULT_VALUE;
                $model->skull = $feedback['violence']['skull'] ?? SELF::DEFAULT_VALUE;
                $model->unconscious = $feedback['violence']['unconscious'] ?? SELF::DEFAULT_VALUE;
                $model->body_waste = $feedback['violence']['body_waste'] ?? SELF::DEFAULT_VALUE;
                $model->type_animated = $feedback['type']['animated'] ?? SELF::DEFAULT_VALUE;
                $model->type_fake = $feedback['type']['fake'] ?? SELF::DEFAULT_VALUE;
                $model->type_real = $feedback['type']['real'] ?? SELF::DEFAULT_VALUE;
                $model->violence = $feedback['violence']['violence'] ?? SELF::DEFAULT_VALUE;
                $model->violence_physical_violence = $feedback['violence']['physical_violence'] ?? SELF::DEFAULT_VALUE;
                $model->violence_firearm_threat = $feedback['violence']['firearm_threat'] ?? SELF::DEFAULT_VALUE;
                $model->violence_combat_sport = $feedback['violence']['combat_sport'] ?? SELF::DEFAULT_VALUE;
                $model->self_harm = $feedback['self_harm']['self_harm'] ?? SELF::DEFAULT_VALUE;
                $model->self_harm_real = $feedback['self_harm']['real'] ?? SELF::DEFAULT_VALUE;
                $model->self_harm_fake = $feedback['self_harm']['fake'] ?? SELF::DEFAULT_VALUE;
                $model->self_harm_animated = $feedback['self_harm']['animated'] ?? SELF::DEFAULT_VALUE;
                $model->save(false);
            }
            return true;
        }

        return false;
    }

    private function updateTextFeedback($moderation_id, $text_feedback)
    {
        $model = new ModerationText();
        $model->moderation_id = $moderation_id;
        $model->sexual = $text_feedback['moderation_classes']['sexual'] ?? SELF::DEFAULT_VALUE;
        $model->discriminatory = $text_feedback['moderation_classes']['discriminatory'] ?? SELF::DEFAULT_VALUE;
        $model->insulting = $text_feedback['moderation_classes']['insulting'] ?? SELF::DEFAULT_VALUE;
        $model->violent = $text_feedback['moderation_classes']['violent'] ?? SELF::DEFAULT_VALUE;
        $model->toxic = $text_feedback['moderation_classes']['toxic'] ?? SELF::DEFAULT_VALUE;
        $model->self_harm = $text_feedback['moderation_classes']['self-harm'] ?? SELF::DEFAULT_VALUE;
        $model->personal = isset($text_feedback['personal']['matches']) && count($text_feedback['personal']['matches']) > 0 ? 1 : 0;
        $model->link = isset($text_feedback['link']['matches']) && count($text_feedback['link']['matches']) > 0 ? 1 : 0;
        if ($model->save(false)) {
            $this->updateTextPersonelFeedback($model->id, $text_feedback['personal']['matches'] ?? []);
            $this->updateLinkFeedback($model->id, $text_feedback['link']['matches'] ?? []);
            return true;
        }
        return false;
    }

    private function updateTextPersonelFeedback($moderation_text_id, $feedbacks)
    {
        if (count($feedbacks) > 0) {
            foreach ($feedbacks as $feedback) {
                $model = new ModerationTextPersonal();
                $model->moderation_text_id = $moderation_text_id;
                $model->type = $feedback['type'] ?? SELF::DEFAULT_VALUE;
                $model->match = $feedback['match'] ?? SELF::DEFAULT_VALUE;
                $model->start = $feedback['start'] ?? 0;
                $model->end = $feedback['end'] ?? 0;
                $model->save(false);
            }
            return true;
        }
        return false;
    }

    private function updateLinkFeedback($moderation_text_id, $feedbacks)
    {
        if (count($feedbacks) > 0) {
            foreach ($feedbacks as $feedback) {
                $model = new ModerationTextPersonal();
                $model->moderation_text_id = $moderation_text_id;
                $model->type = $feedback['type'] ?? SELF::DEFAULT_VALUE;
                $model->category = $feedback['category'] ?? SELF::DEFAULT_VALUE;
                $model->match = $feedback['match'] ?? SELF::DEFAULT_VALUE;
                $model->start = $feedback['start'] ?? SELF::DEFAULT_VALUE;
                $model->end = $feedback['end'] ?? SELF::DEFAULT_VALUE;
                $model->save(false);
            }
            return true;
        }
        return false;
    }

    private function updateImageFeedback($moderation_id, $image_feedback)
    {
       
        $model = new ModerationImage();
        $model->moderation_id = $moderation_id;
        $model->sexual_activity = $image_feedback['nudity']['sexual_activity'] ?? SELF::DEFAULT_VALUE;
        $model->sexual_display = $image_feedback['nudity']['sexual_display'] ?? SELF::DEFAULT_VALUE;
        $model->erotica = $image_feedback['nudity']['erotica'] ?? SELF::DEFAULT_VALUE;
        $model->very_suggestive = $image_feedback['nudity']['very_suggestive'] ?? SELF::DEFAULT_VALUE;
        $model->suggestive = $image_feedback['nudity']['suggestive'] ?? SELF::DEFAULT_VALUE;
        $model->mildly_suggestive = $image_feedback['nudity']['mildly_suggestive'] ?? SELF::DEFAULT_VALUE;
        $model->bikini = $image_feedback['nudity']['suggestive_classes']['bikini'] ?? SELF::DEFAULT_VALUE;
        $model->cleavage = $image_feedback['nudity']['suggestive_classes']['cleavage'] ?? SELF::DEFAULT_VALUE;
        $model->cleavage_very_revealing = $image_feedback['nudity']['suggestive_classes']['cleavage_categories']['very_revealing'] ?? SELF::DEFAULT_VALUE;
        $model->cleavage_revealing = $image_feedback['nudity']['suggestive_classes']['cleavage_categories']['revealing'] ?? SELF::DEFAULT_VALUE;
        $model->lingerie = $image_feedback['nudity']['suggestive_classes']['lingerie'] ?? SELF::DEFAULT_VALUE;
        $model->male_chest = $image_feedback['nudity']['suggestive_classes']['male_chest'] ?? SELF::DEFAULT_VALUE;
        $model->male_chest_very_revealing = $image_feedback['nudity']['suggestive_classes']['male_chest_categories']['very_revealing'] ?? SELF::DEFAULT_VALUE;
        $model->male_chest_revealing = $image_feedback['nudity']['suggestive_classes']['male_chest_categories']['revealing'] ?? SELF::DEFAULT_VALUE;
        $model->male_chest_slightly_revealing = $image_feedback['nudity']['suggestive_classes']['male_chest_categories']['slightly_revealing'] ?? SELF::DEFAULT_VALUE;
        $model->male_underwear = $image_feedback['nudity']['suggestive_classes']['male_underwear'] ?? SELF::DEFAULT_VALUE;
        $model->miniskirt = $image_feedback['nudity']['suggestive_classes']['miniskirt'] ?? SELF::DEFAULT_VALUE;
        $model->minishort = $image_feedback['nudity']['suggestive_classes']['minishort'] ?? SELF::DEFAULT_VALUE;
        $model->nudity_art = $image_feedback['nudity']['suggestive_classes']['nudity_art'] ?? SELF::DEFAULT_VALUE;
        $model->schematic = $image_feedback['nudity']['suggestive_classes']['schematic'] ?? SELF::DEFAULT_VALUE;
        $model->sextoy = $image_feedback['nudity']['suggestive_classes']['sextoy'] ?? SELF::DEFAULT_VALUE;
        $model->suggestive_focus = $image_feedback['nudity']['suggestive_classes']['suggestive_focus'] ?? SELF::DEFAULT_VALUE;
        $model->suggestive_pose = $image_feedback['nudity']['suggestive_classes']['suggestive_pose'] ?? SELF::DEFAULT_VALUE;
        $model->swimwear_male = $image_feedback['nudity']['suggestive_classes']['swimwear_male'] ?? SELF::DEFAULT_VALUE;
        $model->swimwear_one_piece = $image_feedback['nudity']['suggestive_classes']['swimwear_one_piece'] ?? SELF::DEFAULT_VALUE;
        $model->visibly_undressed = $image_feedback['nudity']['suggestive_classes']['visibly_undressed'] ?? SELF::DEFAULT_VALUE;
        $model->context_sea_lake_pool = $image_feedback['nudity']['context']['sea_lake_pool'] ?? SELF::DEFAULT_VALUE;
        $model->context_outdoor_other = $image_feedback['nudity']['context']['outdoor_other'] ?? SELF::DEFAULT_VALUE;
        $model->context_indoor_other = $image_feedback['nudity']['context']['indoor_other'] ?? SELF::DEFAULT_VALUE;
        $model->alcohol = $image_feedback['alcohol']['prob'] ?? SELF::DEFAULT_VALUE;
        $model->type_photo = $image_feedback['type']['photo'] ?? SELF::DEFAULT_VALUE;
        $model->type_illustration = $image_feedback['type']['illustration'] ?? SELF::DEFAULT_VALUE;
        $model->type_ai_generated = $image_feedback['type']['ai_generated'] ?? SELF::DEFAULT_VALUE;
        $model->offensive_nazi = $image_feedback['offensive']['nazi'] ?? SELF::DEFAULT_VALUE;
        $model->offensive_asian_swastika = $image_feedback['offensive']['asian_swastika'] ?? SELF::DEFAULT_VALUE;
        $model->offensive_confederate = $image_feedback['offensive']['confederate'] ?? SELF::DEFAULT_VALUE;
        $model->offensive_supremacist = $image_feedback['offensive']['supremacist'] ?? SELF::DEFAULT_VALUE;
        $model->offensive_terrorist = $image_feedback['offensive']['terrorist'] ?? SELF::DEFAULT_VALUE;
        $model->offensive_middle_finger = $image_feedback['offensive']['middle_finger'] ?? SELF::DEFAULT_VALUE;
        $model->very_bloody = $image_feedback['violence']['very_bloody'] ?? SELF::DEFAULT_VALUE;
        $model->slightly_bloody = $image_feedback['violence']['slightly_bloody'] ?? SELF::DEFAULT_VALUE;
        $model->body_organ = $image_feedback['violence']['body_organ'] ?? SELF::DEFAULT_VALUE;
        $model->serious_injury = $image_feedback['violence']['serious_injury'] ?? SELF::DEFAULT_VALUE;
        $model->superficial_injury = $image_feedback['violence']['superficial_injury'] ?? SELF::DEFAULT_VALUE;
        $model->corpse = $image_feedback['violence']['corpse'] ?? SELF::DEFAULT_VALUE;
        $model->skull = $image_feedback['violence']['skull'] ?? SELF::DEFAULT_VALUE;
        $model->unconscious = $image_feedback['violence']['unconscious'] ?? SELF::DEFAULT_VALUE;
        $model->body_waste = $image_feedback['violence']['body_waste'] ?? SELF::DEFAULT_VALUE;
        $model->type_animated = $image_feedback['type']['animated'] ?? SELF::DEFAULT_VALUE;
        $model->type_fake = $image_feedback['type']['fake'] ?? SELF::DEFAULT_VALUE;
        $model->type_real = $image_feedback['type']['real'] ?? SELF::DEFAULT_VALUE;
        $model->violence = $image_feedback['violence']['violence'] ?? SELF::DEFAULT_VALUE;
        $model->violence_physical_violence = $image_feedback['violence']['physical_violence'] ?? SELF::DEFAULT_VALUE;
        $model->violence_firearm_threat = $image_feedback['violence']['firearm_threat'] ?? SELF::DEFAULT_VALUE;
        $model->violence_combat_sport = $image_feedback['violence']['combat_sport'] ?? SELF::DEFAULT_VALUE;
        $model->self_harm = $image_feedback['self_harm']['self_harm'] ?? SELF::DEFAULT_VALUE;
        $model->self_harm_real = $image_feedback['self_harm']['real'] ?? SELF::DEFAULT_VALUE;
        $model->self_harm_fake = $image_feedback['self_harm']['fake'] ?? SELF::DEFAULT_VALUE;
        $model->self_harm_animated = $image_feedback['self_harm']['animated'] ?? SELF::DEFAULT_VALUE;
        // return $model->save(false);
        if($model->save(false)){
            return true;
        }else{
            exit("Error: " . json_encode($model->errors));
            die();

        }
    }
}
