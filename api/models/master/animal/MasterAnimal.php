<?php

namespace api\models\master\animal;

use api\models\meta\MetaAnimalType;
use api\traits\CommanRelationship;
use api\models\park\SafariParkAnimal;
use Yii;

/**
 * This is the model class for table "master_animal".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $know_as
 * @property string|null $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterAnimal extends \common\models\master\animal\MasterAnimal
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'imagepath';
        $fields[] = 'bannerimagepath';
        // $fields[] = 'rareparkanimals';

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImagepath()
    {
        if ($this->feature_image != '') {
            return \Yii::$app->params['frontend_url'] . '/storage/rareanimal/' . $this->id . '/' . $this->feature_image;
        }
    }

    public function getBannerimagepath()
    {
        if ($this->banner != '') {
            return \Yii::$app->params['frontend_url'] . '/storage/rareanimal/' . $this->id . '/' . $this->banner;
        }
    }


    // public function getRareparkanimals()
    // {
    //     return $this->hasMany(SafariParkAnimal::className(), ['master_animal_id' => 'id'])->andWhere(['safari_parks_animal.status' => 1]);
    // }
}
