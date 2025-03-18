<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "nudity".
 *
 * @property int $id
 * @property float|null $sexual_activity
 * @property float|null $sexual_display
 * @property float|null $erotica
 * @property float|null $very_suggestive
 * @property float|null $suggestive
 * @property float|null $mildly_suggestive
 * @property float|null $bikini
 * @property float|null $cleavage
 * @property float|null $lingerie
 * @property float|null $male_chest
 * @property float|null $male_underwear
 * @property float|null $miniskirt
 * @property float|null $other
 * @property float|null $minishort
 * @property float|null $nudity_art
 * @property float|null $schematic
 * @property float|null $sextoy
 * @property float|null $suggestive_focus
 * @property float|null $suggestive_pose
 * @property float|null $swimwear_male
 * @property float|null $swimwear_one_piece
 * @property float|null $visibly_undressed
 * @property float|null $none
 * @property float|null $sea_lake_pool
 * @property float|null $outdoor_other
 * @property float|null $indoor_other
 * @property float|null $cleavage_very_revealing
 * @property float|null $cleavage_revealing
 * @property float|null $cleavage_none
 * @property float|null $male_chest_
 * @property float|null $male_chest_very_revealing
 * @property float|null $male_chest_revealing
 * @property float|null $male_chest_slightly_revealing
 * @property float|null $male_chest_none
 */
class Nudity extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nudity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'sexual_activity', 'sexual_display', 'erotica', 'very_suggestive', 'suggestive', 'mildly_suggestive', 'bikini', 'cleavage', 'lingerie', 'male_chest', 'male_underwear', 'miniskirt', 'other', 'minishort', 'nudity_art', 'schematic', 'sextoy', 'suggestive_focus', 'suggestive_pose', 'swimwear_male', 'swimwear_one_piece', 'visibly_undressed', 'none', 'sea_lake_pool', 'outdoor_other', 'indoor_other', 'cleavage_very_revealing', 'cleavage_revealing', 'cleavage_none', 'male_chest_', 'male_chest_very_revealing', 'male_chest_revealing', 'male_chest_slightly_revealing', 'male_chest_none'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['sexual_activity', 'sexual_display', 'erotica', 'very_suggestive', 'suggestive', 'mildly_suggestive', 'bikini', 'cleavage', 'lingerie', 'male_chest', 'male_underwear', 'miniskirt', 'other', 'minishort', 'nudity_art', 'schematic', 'sextoy', 'suggestive_focus', 'suggestive_pose', 'swimwear_male', 'swimwear_one_piece', 'visibly_undressed', 'none', 'sea_lake_pool', 'outdoor_other', 'indoor_other', 'cleavage_very_revealing', 'cleavage_revealing', 'cleavage_none', 'male_chest_', 'male_chest_very_revealing', 'male_chest_revealing', 'male_chest_slightly_revealing', 'male_chest_none'], 'number'],
            [['info_id'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moderation_id' => 'Moderation ID',
            'info_id' => 'Info ID',
            'info_position' => 'Info Position',
            'sexual_activity' => 'Sexual Activity',
            'sexual_display' => 'Sexual Display',
            'erotica' => 'Erotica',
            'very_suggestive' => 'Very Suggestive',
            'suggestive' => 'Suggestive',
            'mildly_suggestive' => 'Mildly Suggestive',
            'bikini' => 'Bikini',
            'cleavage' => 'Cleavage',
            'lingerie' => 'Lingerie',
            'male_chest' => 'Male Chest',
            'male_underwear' => 'Male Underwear',
            'miniskirt' => 'Miniskirt',
            'other' => 'Other',
            'minishort' => 'Minishort',
            'nudity_art' => 'Nudity Art',
            'schematic' => 'Schematic',
            'sextoy' => 'Sextoy',
            'suggestive_focus' => 'Suggestive Focus',
            'suggestive_pose' => 'Suggestive Pose',
            'swimwear_male' => 'Swimwear Male',
            'swimwear_one_piece' => 'Swimwear One Piece',
            'visibly_undressed' => 'Visibly Undressed',
            'none' => 'None',
            'sea_lake_pool' => 'Sea Lake Pool',
            'outdoor_other' => 'Outdoor Other',
            'indoor_other' => 'Indoor Other',
            'cleavage_very_revealing' => 'Cleavage Very Revealing',
            'cleavage_revealing' => 'Cleavage Revealing',
            'cleavage_none' => 'Cleavage None',
            'male_chest_' => 'Male Chest',
            'male_chest_very_revealing' => 'Male Chest Very Revealing',
            'male_chest_revealing' => 'Male Chest Revealing',
            'male_chest_slightly_revealing' => 'Male Chest Slightly Revealing',
            'male_chest_none' => 'Male Chest None',
        ];
    }

    // public function nuditystore($fb, $id)
    // {
    //     foreach ($fb['data']['frames'] as $frame) {
    //         $model = new self();
    //         $model->moderation_id = $id;
    //         $model->info_id = $frame['info']['id'];
    //         $model->info_position = $frame['info']['position'];
    //         $model->sexual_activity = $frame['nudity']['sexual_activity'];
    //         $model->sexual_display = $frame['nudity']['sexual_display'];
    //         $model->erotica = $frame['nudity']['erotica'];
    //         $model->very_suggestive = $frame['nudity']['very_suggestive'];
    //         $model->suggestive = $frame['nudity']['suggestive'];
    //         $model->mildly_suggestive = $frame['nudity']['mildly_suggestive'];
    //         $model->bikini = $frame['nudity']['bikini'];
    //         $model->cleavage = $frame['nudity']['cleavage'];
    //         $model->lingerie = $frame['nudity']['lingerie'];
    //         $model->male_chest = $frame['nudity']['male_chest'];
    //         $model->male_underwear = $frame['nudity']['male_underwear'];
    //         $model->miniskirt = $frame['nudity']['miniskirt'];
    //         $model->other = $frame['nudity']['other'];
    //         $model->minishort = $frame['nudity']['minishort'];
    //         $model->nudity_art = $frame['nudity']['nudity_art'];
    //         $model->schematic = $frame['nudity']['schematic'];
    //         $model->sextoy = $frame['nudity']['sextoy'];
    //         $model->suggestive_focus = $frame['nudity']['suggestive_focus'];
    //         $model->suggestive_pose = $frame['nudity']['suggestive_pose'];
    //         $model->swimwear_male = $frame['nudity']['position'];
    //         $model->swimwear_one_piece = $frame['nudity']['swimwear_one_piece'];
    //         $model->visibly_undressed = $frame['nudity']['visibly_undressed'];
    //         $model->none = $frame['nudity']['none'];
    //         $model->sea_lake_pool = $frame['nudity']['sea_lake_pool'];
    //         $model->outdoor_other = $frame['nudity']['outdoor_other'];
    //         $model->indoor_other = $frame['nudity']['indoor_other'];
    //         $model->cleavage_very_revealing = $frame['nudity']['cleavage_categories']['very_revealing'];
    //         $model->cleavage_revealing = $frame['nudity']['cleavage_categories']['revealing'];
    //         $model->cleavage_none = $frame['nudity']['cleavage_categories']['none'];
    //         $model->male_chest_ = $frame['nudity']['male_chest_'];
    //         $model->male_chest_very_revealing = $frame['nudity']['male_chest_categories']['very_revealing'];
    //         $model->male_chest_revealing = $frame['nudity']['male_chest_categories']['revealing'];
    //         $model->male_chest_slightly_revealing = $frame['nudity']['male_chest_categories']['slightly_revealing'];
    //         $model->male_chest_none = $frame['nudity']['male_chest_categories']['none'];
    //         $model->save(false);
    //     }
    // }

    public function nuditystore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->sexual_activity = $frame['nudity']['sexual_activity'] ?? 0;
            $model->sexual_display = $frame['nudity']['sexual_display'] ?? 0;
            $model->erotica = $frame['nudity']['erotica'] ?? 0;
            $model->very_suggestive = $frame['nudity']['very_suggestive'] ?? 0;
            $model->suggestive = $frame['nudity']['suggestive'] ?? 0;
            $model->mildly_suggestive = $frame['nudity']['mildly_suggestive'] ?? 0;
            $model->bikini = $frame['suggestive_classes']['bikini'] ?? 0;
            $model->cleavage = $frame['suggestive_classes']['cleavage'] ?? 0;
            $model->lingerie = $frame['cleavage_categories']['lingerie'] ?? 0;
            $model->male_chest = $frame['male_chest_categories']['male_chest'] ?? 0;
            $model->male_underwear = $frame['male_chest_categories']['male_underwear'] ?? 0;
            $model->miniskirt = $frame['nudity']['miniskirt'] ?? 0;
            $model->other = $frame['nudity']['other'] ?? 0;
            $model->minishort = $frame['nudity']['minishort'] ?? 0;
            $model->nudity_art = $frame['nudity']['nudity_art'] ?? 0;
            $model->schematic = $frame['nudity']['schematic'] ?? 0;
            $model->sextoy = $frame['nudity']['sextoy'] ?? 0;
            $model->suggestive_focus = $frame['nudity']['suggestive_focus'] ?? 0;
            $model->suggestive_pose = $frame['nudity']['suggestive_pose'] ?? 0;
            $model->swimwear_male = $frame['nudity']['swimwear_male'] ?? 0;
            $model->swimwear_one_piece = $frame['nudity']['swimwear_one_piece'] ?? 0;
            $model->visibly_undressed = $frame['nudity']['visibly_undressed'] ?? 0;
            $model->none = $frame['nudity']['none'] ?? 0;
            $model->sea_lake_pool = $frame['context']['sea_lake_pool'] ?? 0;
            $model->outdoor_other = $frame['context']['outdoor_other'] ?? 0;
            $model->indoor_other = $frame['context']['indoor_other'] ?? 0;
            $model->cleavage_very_revealing = $frame['cleavage_categories']['very_revealing'] ?? 0;
            $model->cleavage_revealing = $frame['cleavage_categories']['revealing'] ?? 0;
            $model->cleavage_none = $frame['cleavage_categories']['none'] ?? 0;
            $model->male_chest_ = $frame['nudity']['male_chest_'] ?? 0;
            $model->male_chest_very_revealing = $frame['male_chest_categories']['very_revealing'] ?? 0;
            $model->male_chest_revealing = $frame['male_chest_categories']['revealing'] ?? 0;
            $model->male_chest_slightly_revealing = $frame['male_chest_categories']['slightly_revealing'] ?? 0;
            $model->male_chest_none = $frame['male_chest_categories']['none'] ?? 0;
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}
