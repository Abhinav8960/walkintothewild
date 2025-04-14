<?php

namespace common\models\firebasenotification;


class ActiveLogRecord extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return \Yii::$app->db_logs; 
    }
}
