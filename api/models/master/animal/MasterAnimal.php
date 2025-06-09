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
        $fields = [
            'id',
            'name',
            'slug',
            'short_description',
            'banner',
            'feature_image',
            'know_as',
            'animal_type',
            'is_feature_sequence',
            'is_filter' => function () {
                return (bool)$this->is_filter;
            },
            'is_filter_sequence',
            'is_searchable' => function () {
                return (bool)$this->is_searchable;
            },
            'total_view',
        ];
        
        $fields[] = 'image_path';
        $fields[] = 'banner_image_path';
        // $fields[] = 'rareparkanimals';

        // $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        // return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImage_path()
    {
        // if ($this->feature_image != '') {
        //     return \Yii::$app->params['s3_endpoint'] . '/rareanimal/' . $this->id . '/' . $this->feature_image;
        // }
        if ($this->feature_image != '') {
            return \Yii::$app->params['s3_endpoint'] . '/' . $this->feature_image_path;
        }
    }

    public function getBanner_image_path()
    {
        // if ($this->banner != '') {
        //     return \Yii::$app->params['s3_endpoint'] . '/rareanimal/' . $this->id . '/' . $this->banner;
        // }
        if ($this->banner != '') {
            return \Yii::$app->params['s3_endpoint'] . '/' . $this->banner_path;
        }
    }


    // public function getRareparkanimals()
    // {
    //     return $this->hasMany(SafariParkAnimal::className(), ['master_animal_id' => 'id'])->andWhere(['safari_parks_animal.status' => 1]);
    // }
}
