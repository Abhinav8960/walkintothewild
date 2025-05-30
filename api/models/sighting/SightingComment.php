<?php

namespace api\models\sighting;

use Yii;
use api\models\User;
use common\models\GeneralModel;

class SightingComment extends \common\models\sighting\SightingComment
{
    public function fields()
    {
        // $fields = parent::fields();
        // $fields[] = 'user';
        // $fields[] = 'replies';
        // $fields[] = 'is_liked';
        // $fields[] = 'liked_count';
        // $hold_fields = ['sighting_id', 'user_id', 'parent_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        // return array_diff($fields, $hold_fields);
        // return $fields;
        $fields = ['id', 'safari_operator_id', 'comment' => function ($model) {
            return GeneralModel::apicommentConversion($model->comment);
        }, 'dateTime', 'flaged' => function () {
            return (bool) $this->flaged;
        }, 'user', 'replies', 'is_liked', 'liked_count'];

        return $fields;
    }


    public function getSighting()
    {
        return $this->hasOne(Sighting::className(), ['id' => 'sighting_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])->andWhere(['sighting_comment.status' => 1]);
    }

    public function getIs_liked()
    {
        $is_liked = SightingCommentLike::find()->where(['sighting_comment_id' => $this->id, 'user_id' => \Yii::$app->params['active_user_id'], 'sighting_comment_like.status' => 1])->limit(1)->one();
        if ($is_liked) {
            return true;
        }
        return false;
    }

    public function getLike()
    {
        return $this->hasMany(SightingCommentLike::class, ['sighting_comment_id' => 'id'])->andWhere(['sighting_comment_like.status' => 1]);
    }

    public function getLiked_count()
    {
        return $this->getLike()->count();
    }
}
