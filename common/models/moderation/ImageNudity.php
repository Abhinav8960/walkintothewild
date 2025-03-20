<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_nudity".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 * @property int|null $request_timestamp
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
 * @property float|null $male_chest_very_revealing
 * @property float|null $male_chest_revealing
 * @property float|null $male_chest_slightly_revealing
 * @property float|null $male_chest_none
 */
class ImageNudity extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_nudity';
    }

    /**
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_moderation');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_id', 'request_timestamp', 'sexual_activity', 'sexual_display', 'erotica', 'very_suggestive', 'suggestive', 'mildly_suggestive', 'bikini', 'cleavage', 'lingerie', 'male_chest', 'male_underwear', 'miniskirt', 'other', 'minishort', 'nudity_art', 'schematic', 'sextoy', 'suggestive_focus', 'suggestive_pose', 'swimwear_male', 'swimwear_one_piece', 'visibly_undressed', 'none', 'sea_lake_pool', 'outdoor_other', 'indoor_other', 'cleavage_very_revealing', 'cleavage_revealing', 'cleavage_none', 'male_chest_very_revealing', 'male_chest_revealing', 'male_chest_slightly_revealing', 'male_chest_none'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'request_timestamp'], 'integer'],
            [['sexual_activity', 'sexual_display', 'erotica', 'very_suggestive', 'suggestive', 'mildly_suggestive', 'bikini', 'cleavage', 'lingerie', 'male_chest', 'male_underwear', 'miniskirt', 'other', 'minishort', 'nudity_art', 'schematic', 'sextoy', 'suggestive_focus', 'suggestive_pose', 'swimwear_male', 'swimwear_one_piece', 'visibly_undressed', 'none', 'sea_lake_pool', 'outdoor_other', 'indoor_other', 'cleavage_very_revealing', 'cleavage_revealing', 'cleavage_none', 'male_chest_very_revealing', 'male_chest_revealing', 'male_chest_slightly_revealing', 'male_chest_none'], 'number'],
            [['media_id'], 'string', 'max' => 512],
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
            'media_id' => 'Media ID',
            'request_timestamp' => 'Request Timestamp',
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
            'male_chest_very_revealing' => 'Male Chest Very Revealing',
            'male_chest_revealing' => 'Male Chest Revealing',
            'male_chest_slightly_revealing' => 'Male Chest Slightly Revealing',
            'male_chest_none' => 'Male Chest None',
        ];
    }

    public static function nudityStore($feedback, $moderationId)
    {
        if (!isset($feedback['nudity']) || !is_array($feedback['nudity'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;

        $model->sexual_activity = $feedback['nudity']['sexual_activity'] ?? 0;
        $model->sexual_display = $feedback['nudity']['sexual_display'] ?? 0;
        $model->erotica = $feedback['nudity']['erotica'] ?? 0;
        $model->very_suggestive = $feedback['nudity']['very_suggestive'] ?? 0;
        $model->suggestive = $feedback['nudity']['suggestive'] ?? 0;
        $model->mildly_suggestive = $feedback['nudity']['mildly_suggestive'] ?? 0;

        $suggestiveClasses = $feedback['nudity']['suggestive_classes'] ?? [];
        $model->bikini = $suggestiveClasses['bikini'] ?? 0;
        $model->cleavage = $suggestiveClasses['cleavage'] ?? 0;
        $model->lingerie = $suggestiveClasses['lingerie'] ?? 0;
        $model->male_chest = $suggestiveClasses['male_chest'] ?? 0;
        $model->male_underwear = $suggestiveClasses['male_underwear'] ?? 0;
        $model->miniskirt = $suggestiveClasses['miniskirt'] ?? 0;
        $model->minishort = $suggestiveClasses['minishort'] ?? 0;
        $model->nudity_art = $suggestiveClasses['nudity_art'] ?? 0;
        $model->schematic = $suggestiveClasses['schematic'] ?? 0;
        $model->sextoy = $suggestiveClasses['sextoy'] ?? 0;
        $model->suggestive_focus = $suggestiveClasses['suggestive_focus'] ?? 0;
        $model->suggestive_pose = $suggestiveClasses['suggestive_pose'] ?? 0;
        $model->swimwear_male = $suggestiveClasses['swimwear_male'] ?? 0;
        $model->swimwear_one_piece = $suggestiveClasses['swimwear_one_piece'] ?? 0;
        $model->visibly_undressed = $suggestiveClasses['visibly_undressed'] ?? 0;
        $model->other = $suggestiveClasses['other'] ?? 0;

        $cleavageCategories = $suggestiveClasses['cleavage_categories'] ?? [];
        $model->cleavage_very_revealing = $cleavageCategories['very_revealing'] ?? 0;
        $model->cleavage_revealing = $cleavageCategories['revealing'] ?? 0;
        $model->cleavage_none = $cleavageCategories['none'] ?? 0;

        $maleChestCategories = $suggestiveClasses['male_chest_categories'] ?? [];
        $model->male_chest_very_revealing = $maleChestCategories['very_revealing'] ?? 0;
        $model->male_chest_revealing = $maleChestCategories['revealing'] ?? 0;
        $model->male_chest_slightly_revealing = $maleChestCategories['slightly_revealing'] ?? 0;
        $model->male_chest_none = $maleChestCategories['none'] ?? 0;

        $context = $feedback['nudity']['context'] ?? [];
        $model->sea_lake_pool = $context['sea_lake_pool'] ?? 0;
        $model->outdoor_other = $context['outdoor_other'] ?? 0;
        $model->indoor_other = $context['indoor_other'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
