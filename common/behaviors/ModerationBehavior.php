<?php
// filepath: /home/ak/project/walkintothewild/common/behaviors/ModerationBehavior.php
namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ModerationBehavior extends Behavior
{
    public $attributes = [];
    public $type_options = [];
    public $type;
    public $end_ponit = 'https://d281t0xjcq032r.cloudfront.net/';
    public $collection;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'moderateContent',
            ActiveRecord::EVENT_AFTER_UPDATE => 'moderateContent',
        ];
    }

    public function moderateContent($event)
    {
        $type = $this->type;
        // echo "<pre>";
        // print_r($event);
        // die();

        // $type = $this->owner->$type;
        // if ($type) {
        //     $type = $this->type_options[$type];
        // }


        foreach ($this->attributes as $attributes) {
            $content = $this->owner->$attributes;
            if ($content) {
                \Yii::$app->moderation->prepareModeration($this->end_ponit , $content, $type, $this->collection, $this->owner->id);
            }
        }
    }


}
