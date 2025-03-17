<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "moderation_image".
 *
 * @property int $id
 * @property string $moderation_id
 * @property string $media_id
 * @property float $sexual_activity
 * @property float $sexual_display
 * @property float $erotica
 * @property float $very_suggestive
 * @property float $suggestive
 * @property float $mildly_suggestive
 * @property float $bikini
 * @property float $cleavage
 * @property float $cleavage_very_revealing
 * @property float $cleavage_revealing
 * @property float $lingerie
 * @property float $male_chest
 * @property float $male_chest_very_revealing
 * @property float $male_chest_revealing
 * @property float $male_chest_slightly_revealing
 * @property float $male_underwear
 * @property float $miniskirt
 * @property float $minishort
 * @property float $nudity_art
 * @property float $schematic
 * @property float $sextoy
 * @property float|null $suggestive_focus
 * @property float $suggestive_pose
 * @property float $swimwear_male
 * @property float $swimwear_one_piece
 * @property float $visibly_undressed
 * @property float $other
 * @property float $context_sea_lake_pool
 * @property float $context_outdoor_other
 * @property float $context_indoor_other
 * @property float $alcohol
 * @property float $type_photo
 * @property float $type_illustration
 * @property float $type_ai_generated
 * @property float $offensive_nazi
 * @property float $offensive_asian_swastika
 * @property float $offensive_confederate
 * @property float $offensive_supremacist
 * @property float $offensive_terrorist
 * @property float $offensive_middle_finger
 * @property float $very_bloody
 * @property float $slightly_bloody
 * @property float $body_organ
 * @property float $serious_injury
 * @property float $superficial_injury
 * @property float $corpse
 * @property float $skull
 * @property float $unconscious
 * @property float $body_waste
 * @property float $type_animated
 * @property float $type_fake
 * @property float $type_real
 * @property float $violence
 * @property float $violence_physical_violence
 * @property float $violence_firearm_threat
 * @property float $violence_combat_sport
 * @property float $self_harm
 * @property float $self_harm_real
 * @property float $self_harm_fake
 * @property float $self_harm_animated
 */
class ModerationImage extends \common\models\moderation\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moderation_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['self_harm_animated'], 'default', 'value' => 0.000],
            [['moderation_id', 'type_real'], 'required'],
            [['media_id'], 'safe'],
            [['sexual_activity', 'sexual_display', 'erotica', 'very_suggestive', 'suggestive', 'mildly_suggestive', 'bikini', 'cleavage', 'cleavage_very_revealing', 'cleavage_revealing', 'lingerie', 'male_chest', 'male_chest_very_revealing', 'male_chest_revealing', 'male_chest_slightly_revealing', 'male_underwear', 'miniskirt', 'minishort', 'nudity_art', 'schematic', 'sextoy', 'suggestive_focus', 'suggestive_pose', 'swimwear_male', 'swimwear_one_piece', 'visibly_undressed', 'other', 'context_sea_lake_pool', 'context_outdoor_other', 'context_indoor_other', 'alcohol', 'type_photo', 'type_illustration', 'type_ai_generated', 'offensive_nazi', 'offensive_asian_swastika', 'offensive_confederate', 'offensive_supremacist', 'offensive_terrorist', 'offensive_middle_finger', 'very_bloody', 'slightly_bloody', 'body_organ', 'serious_injury', 'superficial_injury', 'corpse', 'skull', 'unconscious', 'body_waste', 'type_animated', 'type_fake', 'type_real', 'violence', 'violence_physical_violence', 'violence_firearm_threat', 'violence_combat_sport', 'self_harm', 'self_harm_real', 'self_harm_fake', 'self_harm_animated'], 'number'],
            [['moderation_id'], 'string', 'max' => 255],
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
            'media_id' => 'Media Id',
            'sexual_activity' => 'Sexual Activity',
            'sexual_display' => 'Sexual Display',
            'erotica' => 'Erotica',
            'very_suggestive' => 'Very Suggestive',
            'suggestive' => 'Suggestive',
            'mildly_suggestive' => 'Mildly Suggestive',
            'bikini' => 'Bikini',
            'cleavage' => 'Cleavage',
            'cleavage_very_revealing' => 'Cleavage Very Revealing',
            'cleavage_revealing' => 'Cleavage Revealing',
            'lingerie' => 'Lingerie',
            'male_chest' => 'Male Chest',
            'male_chest_very_revealing' => 'Male Chest Very Revealing',
            'male_chest_revealing' => 'Male Chest Revealing',
            'male_chest_slightly_revealing' => 'Male Chest Slightly Revealing',
            'male_underwear' => 'Male Underwear',
            'miniskirt' => 'Miniskirt',
            'minishort' => 'Minishort',
            'nudity_art' => 'Nudity Art',
            'schematic' => 'Schematic',
            'sextoy' => 'Sextoy',
            'suggestive_focus' => 'Suggestive Focus',
            'suggestive_pose' => 'Suggestive Pose',
            'swimwear_male' => 'Swimwear Male',
            'swimwear_one_piece' => 'Swimwear One Piece',
            'visibly_undressed' => 'Visibly Undressed',
            'other' => 'Other',
            'context_sea_lake_pool' => 'Context Sea Lake Pool',
            'context_outdoor_other' => 'Context Outdoor Other',
            'context_indoor_other' => 'Context Indoor Other',
            'alcohol' => 'Alcohol',
            'type_photo' => 'Type Photo',
            'type_illustration' => 'Type Illustration',
            'type_ai_generated' => 'Type Ai Generated',
            'offensive_nazi' => 'Offensive Nazi',
            'offensive_asian_swastika' => 'Offensive Asian Swastika',
            'offensive_confederate' => 'Offensive Confederate',
            'offensive_supremacist' => 'Offensive Supremacist',
            'offensive_terrorist' => 'Offensive Terrorist',
            'offensive_middle_finger' => 'Offensive Middle Finger',
            'very_bloody' => 'Very Bloody',
            'slightly_bloody' => 'Slightly Bloody',
            'body_organ' => 'Body Organ',
            'serious_injury' => 'Serious Injury',
            'superficial_injury' => 'Superficial Injury',
            'corpse' => 'Corpse',
            'skull' => 'Skull',
            'unconscious' => 'Unconscious',
            'body_waste' => 'Body Waste',
            'type_animated' => 'Type Animated',
            'type_fake' => 'Type Fake',
            'type_real' => 'Type Real',
            'violence' => 'Violence',
            'violence_physical_violence' => 'Violence Physical Violence',
            'violence_firearm_threat' => 'Violence Firearm Threat',
            'violence_combat_sport' => 'Violence Combat Sport',
            'self_harm' => 'Self Harm',
            'self_harm_real' => 'Self Harm Real',
            'self_harm_fake' => 'Self Harm Fake',
            'self_harm_animated' => 'Self Harm Animated',
        ];
    }

}