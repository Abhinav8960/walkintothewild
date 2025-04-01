<?php

namespace api\models\feeds;

use Yii;


class Feeds extends \common\models\feeds\Feeds
{
    public function fields()
    {
        $fields = ['objective'];
        $fields[] = 'feed';



        return $fields;
    }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function rules()
    // {
    //     return [

    //     ];
    // }


    public function GetFeed()
    {
        return $this->hasOne($this->getObjectiveClass(), ['id' => 'collection_id']);
    }

    public function getObjectiveClass()
    {
        if ($this->collection == Self::MODEL_SHARESFARI) {
            return \api\models\sharesafari\ShareSafari::className();
        } elseif ($this->collection == Self::MODEL_PACKAGE) {
            return \api\models\package\Package::className();
        } elseif ($this->collection == Self::MODEL_POSTS) {
            return \api\models\posts\UserPosts::className();
        }
    }
}
