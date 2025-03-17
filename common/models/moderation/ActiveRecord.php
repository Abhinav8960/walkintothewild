<?php

namespace common\models\moderation;


class ActiveRecord extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return \Yii::$app->db_moderation; 
    }
}
