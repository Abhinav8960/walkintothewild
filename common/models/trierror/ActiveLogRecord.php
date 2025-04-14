<?php

namespace common\models\trierror;


class ActiveLogRecord extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return \Yii::$app->db_logs; 
    }
}
