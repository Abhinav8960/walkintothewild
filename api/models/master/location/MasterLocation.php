<?php

namespace api\models\master\location;

use api\models\master\city\MasterCity;
use api\models\master\country\MasterCountry;
use api\models\master\state\MasterState;
use api\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_location".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class MasterLocation extends \common\models\master\location\MasterLocation
{
    public function fields()
    {
        $fields = parent::fields();

        $hold_fields = ['status', 'sequence', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }
}
