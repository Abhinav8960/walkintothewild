<?php

namespace common\models\moderation;

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
class ImageNudity extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_nudity';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
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

}
