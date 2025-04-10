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
        if ($this->collection == Self::MODEL_SHARESFARI) {
            return $this->hasOne(\api\models\sharesafari\ShareSafari::className(), ['id' => 'collection_id']);
        } elseif ($this->collection == Self::MODEL_PACKAGE) {
            return $this->hasOne(\api\models\package\Package::className(), ['id' => 'collection_id']);
        } elseif ($this->collection == Self::MODEL_POSTS) {
            return $this->hasOne(\api\models\posts\UserPosts::className(), ['id' => 'collection_id']);
        } elseif ($this->collection == Self::MODEL_SIGHTING) {
            return $this->hasOne(\api\models\sighting\Sighting::className(), ['id' => 'collection_id']);
        }
        return [];
    }

}
