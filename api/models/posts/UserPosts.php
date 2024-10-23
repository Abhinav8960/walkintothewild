<?php

namespace api\models\posts;

use Yii;

class UserPosts extends \common\models\UserPosts
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'imagepath';
        $hold_fields = ['file', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);

        return $fields;
    }

    // public function getImagepath()
    // {
    //     if ($this->file != '') {
    //         return Yii::$app->params['frontend_url'] . 'storage/userpost/' . $this->user_id . '/' . $this->file;
    //     }
    // }

    public function getImagepath()
    {
        // return \Yii::$app->fs->temporaryUrl('images/'.$this->id . '.' . strtolower($this->extension),  new \DateTimeImmutable('+1 Minutes'));

        return $this->filepath;
        // return  \Yii::$app->get('fs')->publicUrl('watchpost/' . $this->user_id . '/media/' . $this->file);
    }
}
