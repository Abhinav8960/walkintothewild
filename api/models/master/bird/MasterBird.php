<?php

namespace api\models\master\bird;

use api\models\meta\MetaBirdType;
use api\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_bird".
 *
 * @property int $id
 * @property string $name
 * @property string|null $bird_type_id
 * @property string $slug
 * @property string|null $know_as
 * @property string|null $short_description
 * @property string|null $long_description
 * @property string|null $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterBird extends \common\models\master\bird\MasterBird
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'imagepath';
        $fields[] = 'Birdtype';

        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImagepath()
    {
        if ($this->image != '') {
            return  \Yii::$app->params['frontend_url'] . '/storage/bird/' . $this->id . '/' . $this->image;
        }
    }

    public function getBirdtype()
    {
        return $this->hasOne(MetaBirdType::className(), ['id' => 'bird_type_id']);
    }
}
