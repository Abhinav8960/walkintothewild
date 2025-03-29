<?php

namespace api\models\sharesafari;

use api\models\master\packageinclude\MasterPackageInclude;
use Yii;
use yii\base\Model;

class ShareSafariIncluded extends \common\models\sharesafari\ShareSafariIncluded
{
    public function fields()
    {
        $fields = [
            'masterId',
            'title',
            'option'
        ];
        return $fields;
    }

    public function getMasterPackageInclude()
    {
        return $this->hasOne(MasterPackageInclude::class, ['id' => 'include_id']);
    }

    public function getOption()
    {
        if ($this->selection == 1) {
            return 'Included';
        } elseif ($this->selection == 2) {
            return 'Not Included';
        } else {
            return 'Optional';
        }
    }



    public function getTitle()
    {
        return isset($this->masterPackageInclude) ? $this->masterPackageInclude->title : '';
    }

    public function getMasterId()
    {
        return isset($this->masterPackageInclude) ? $this->masterPackageInclude->id : '';
    }
}
