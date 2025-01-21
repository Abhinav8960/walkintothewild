<?php

namespace api\models\sharesafari;

use api\models\master\packageinclude\MasterPackageInclude;
use Yii;
use yii\base\Model;

class ShareSafariIncluded extends \common\models\sharesafari\ShareSafariIncluded
{
    public function fields()
    {
        $fields = parent::fields();
        // $fields[] = 'id';
        $fields[] = 'title';
        $fields[] = 'option';

        $hold_fields = ['id', 'selection', 'include_id', 'share_safari_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getMasterPackageInclude()
    {
        return $this->hasOne(MasterPackageInclude::class, ['id' => 'include_id']);
    }

    public function getOption()
    {
        if ($this->selection == 1) {
            return 'Include';
        } elseif ($this->selection == 2) {
            return 'Not Include';
        } else {
            return 'Optional';
        }
    }



    public function getTitle()
    {
        return $this->masterPackageInclude->title;
    }
}
