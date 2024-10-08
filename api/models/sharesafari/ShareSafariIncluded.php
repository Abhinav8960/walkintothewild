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
        $fields[] = 'selectionOption';

        $hold_fields = ['id', 'selection', 'include_id', 'share_safari_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getMasterPackageInclude()
    {
        return $this->hasOne(MasterPackageInclude::class, ['id' => 'include_id']);
    }

    public function getSelectionOption()
    {
        $options = [
            '1' => 'Included',
            '2' => 'Not Included',
        ];
        return isset($options[$this->selection]) ? $options[$this->selection] : $this->selection;
    }



    public function getTitle()
    {
        return $this->masterPackageInclude->title;
    }
}
