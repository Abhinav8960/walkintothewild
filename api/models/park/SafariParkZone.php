<?php

namespace api\models\park;

use common\models\GeneralModel;
use common\models\park\SafariParkMonth;
use Yii;

/**
 * This is the model class for table "safari_park_zone".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property int $master_zone_type_id
 * @property int $master_zone_type_name
 * @property string $zone_name
 * @property string $entry_gate_name
 * @property string|null $entry_gate_latitude
 * @property string|null $entry_gate_longitude
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariParkZone extends \common\models\park\SafariParkZone
{
    public function fields()
    {
        // $fields = parent::fields();
        $fields = [
            'id',
            'master_zone_type_name',
            'zone_name',
            'entry_gate_name',
            'entry_gate_latitude',
            'entry_gate_longitude',
            // 'is_open_in_monsoon' => function () {
            //     return (bool)$this->is_open_in_monsoon;
            // },
            'is_open_in_monsoon' => function () {
                return (bool)$this->active_label;
            },
            'open_after_date',
            // 'active_label'
        ];

        // return array_diff($fields, $hold_fields);
        return $fields;
    }

    // public function getActive_label()
    // {
    //     $locked_months = \yii\helpers\ArrayHelper::map(SafariParkMonth::find()->where(['safari_park_id' => $this->safari_park_id, 'status' => SafariParkMonth::STATUS_ACTIVE])->orderBy(['month_id' => SORT_ASC])->all(), 'month_id', 'mastermonth.month_name');

    //     if ($this->master_zone_type_id == 1) {
    //         if ($this->totalCore == false) {
    //             return false;
    //         } else {
    //             if (!in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months))) {
    //                 if ($this->zone_name == 'N/A' && $this->entry_gate_name == 'N/A') {
    //                     return false;
    //                 } else {
    //                     return true;
    //                 }
    //             } else {
    //                 if ($this->is_open_in_monsoon == 0) {
    //                     return false;
    //                 } else if ($this->zone_name == 'N/A' && $this->entry_gate_name == 'N/A' && $this->is_open_in_monsoon == 0) {
    //                     return false;
    //                 } else if ($this->zone_name == 'N/A' && $this->entry_gate_name == 'N/A' && $this->is_open_in_monsoon == 1) {
    //                     return false;
    //                 } else {
    //                     return true;
    //                 }
    //                 if ($this->is_open_in_monsoon == 1) {
    //                     return true;
    //                 }
    //             }
    //             if (isset($this->open_after_date) && $this->open_after_date <> '' && $this->open_after_date > date('Y-m-d')) {
    //                 return false;
    //             } else {
    //                 return true;
    //             }
    //         }
    //     } else {
    //         if ($this->totalBuffer == false) {
    //             return false;
    //         } else {
    //             if (!in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months))) {
    //                 if ($this->zone_name == 'N/A' && $this->entry_gate_name == 'N/A') {
    //                     return false;
    //                 } else {
    //                     return true;
    //                 }
    //             } else {
    //                 if ($this->is_open_in_monsoon == 0) {
    //                     return false;
    //                 } else if ($this->zone_name == 'N/A' && $this->entry_gate_name == 'N/A' && $this->is_open_in_monsoon == 0) {
    //                     return false;
    //                 } else if ($this->zone_name == 'N/A' && $this->entry_gate_name == 'N/A' && $this->is_open_in_monsoon == 1) {
    //                     return false;
    //                 } else {
    //                     return true;
    //                 }
    //             }

    //             if (isset($this->open_after_date) && $this->open_after_date <> '' && $this->open_after_date > date('Y-m-d')) {
    //                 return false;
    //             } else {
    //                 return true;
    //             }
    //         }
    //     }
    // }


    public function getActive_label()
    {
        $locked_months = \yii\helpers\ArrayHelper::map(SafariParkMonth::find()->where(['safari_park_id' => $this->safari_park_id, 'status' => SafariParkMonth::STATUS_ACTIVE])->orderBy(['month_id' => SORT_ASC])->all(), 'month_id', 'mastermonth.month_name');


        if (trim($this->zone_name) == 'N/A' && trim($this->entry_gate_name) == 'N/A') {
            return false;
        } else {
            if (in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months))) {
                if ($this->is_open_in_monsoon == true) {
                    if (isset($this->open_after_date) && $this->open_after_date <> '' && $this->open_after_date > date('Y-m-d')) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            } else {
                if (isset($this->open_after_date) && $this->open_after_date <> '' && $this->open_after_date > date('Y-m-d')) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    // public function getTotalBuffer()
    // {
    //     $locked_months = \yii\helpers\ArrayHelper::map(SafariParkMonth::find()->where(['safari_park_id' => $this->safari_park_id, 'status' => SafariParkMonth::STATUS_ACTIVE])->orderBy(['month_id' => SORT_ASC])->all(), 'month_id', 'mastermonth.month_name');

    //     $total_closed_zone = 0;
    //     if ($this->safariPark->bufferzones) {
    //         foreach ($this->safariPark->bufferzones as $bufferzone) {
    //             if (!in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months))) {
    //                 if ($bufferzone->zone_name == 'N/A' && $bufferzone->entry_gate_name == 'N/A') {
    //                     $total_closed_zone++;
    //                 }
    //             } else {
    //                 if ($bufferzone->is_open_in_monsoon == 0) {
    //                     $total_closed_zone++;
    //                 } else if ($bufferzone->zone_name == 'N/A' && $bufferzone->entry_gate_name == 'N/A' && $bufferzone->is_open_in_monsoon == 0) {
    //                     $total_closed_zone++;
    //                 } else if ($bufferzone->zone_name == 'N/A' && $bufferzone->entry_gate_name == 'N/A' && $bufferzone->is_open_in_monsoon == 1) {
    //                 }
    //                 if ($bufferzone->is_open_in_monsoon == 1) {
    //                     $total_closed_zone--;
    //                 }
    //             }
    //         }

    //         if (count($this->safariPark->bufferzones) == $total_closed_zone) {
    //             return false;
    //         }
    //         return true;
    //     }
    //     return true;
    // }

    // public function getTotalCore()
    // {
    //     $locked_months = \yii\helpers\ArrayHelper::map(SafariParkMonth::find()->where(['safari_park_id' => $this->safari_park_id, 'status' => SafariParkMonth::STATUS_ACTIVE])->orderBy(['month_id' => SORT_ASC])->all(), 'month_id', 'mastermonth.month_name');

    //     $total_core_closed_zone = 0;
    //     if ($this->safariPark->corezones) {
    //         foreach ($this->safariPark->corezones as $corezone) {
    //             if (!in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months))) {
    //                 if ($corezone->zone_name == 'N/A' && $corezone->entry_gate_name == 'N/A') {
    //                     $total_core_closed_zone++;
    //                 } else {
    //                     $total_core_closed_zone--;
    //                 }
    //             } else {
    //                 if ($corezone->is_open_in_monsoon == 0) {
    //                     $total_core_closed_zone++;
    //                 } else if ($corezone->zone_name == 'N/A' && $corezone->entry_gate_name == 'N/A' && $corezone->is_open_in_monsoon == 0) {
    //                     $total_core_closed_zone++;
    //                 } else if ($corezone->zone_name == 'N/A' && $corezone->entry_gate_name == 'N/A' && $corezone->is_open_in_monsoon == 1) {
    //                 }
    //                 if ($corezone->is_open_in_monsoon == 1) {
    //                     $total_core_closed_zone--;
    //  public function getTotalBuffer()
    // {
    //     $locked_months = \yii\helpers\ArrayHelper::map(SafariParkMonth::find()->where(['safari_park_id' => $this->safari_park_id, 'status' => SafariParkMonth::STATUS_ACTIVE])->orderBy(['month_id' => SORT_ASC])->all(), 'month_id', 'mastermonth.month_name');

    //     $total_closed_zone = 0;
    //     if ($this->safariPark->bufferzones) {
    //         foreach ($this->safariPark->bufferzones as $bufferzone) {
    //             if (!in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months))) {
    //                 if ($bufferzone->zone_name == 'N/A' && $bufferzone->entry_gate_name == 'N/A') {
    //                     $total_closed_zone++;
    //                 }
    //             } else {
    //                 if ($bufferzone->is_open_in_monsoon == 0) {
    //                     $total_closed_zone++;
    //                 } else if ($bufferzone->zone_name == 'N/A' && $bufferzone->entry_gate_name == 'N/A' && $bufferzone->is_open_in_monsoon == 0) {
    //                     $total_closed_zone++;
    //                 } else if ($bufferzone->zone_name == 'N/A' && $bufferzone->entry_gate_name == 'N/A' && $bufferzone->is_open_in_monsoon == 1) {
    //                 }
    //                 if ($bufferzone->is_open_in_monsoon == 1) {
    //                     $total_closed_zone--;
    //                 }
    //             }
    //         }

    //         if (count($this->safariPark->bufferzones) == $total_closed_zone) {
    //             return false;
    //         }
    //         return true;
    //     }
    //     return true;
    // }

    // public function getTotalCore()
    // {
    //     $locked_months = \yii\helpers\ArrayHelper::map(SafariParkMonth::find()->where(['safari_park_id' => $this->safari_park_id, 'status' => SafariParkMonth::STATUS_ACTIVE])->orderBy(['month_id' => SORT_ASC])->all(), 'month_id', 'mastermonth.month_name');

    //     $total_core_closed_zone = 0;
    //     if ($this->safariPark->corezones) {
    //         foreach ($this->safariPark->corezones as $corezone) {
    //             if (!in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months))) {
    //                 if ($corezone->zone_name == 'N/A' && $corezone->entry_gate_name == 'N/A') {
    //                     $total_core_closed_zone++;
    //                 } else {
    //                     $total_core_closed_zone--;
    //                 }
    //             } else {
    //                 if ($corezone->is_open_in_monsoon == 0) {
    //                     $total_core_closed_zone++;
    //                 } else if ($corezone->zone_name == 'N/A' && $corezone->entry_gate_name == 'N/A' && $corezone->is_open_in_monsoon == 0) {
    //                     $total_core_closed_zone++;
    //                 } else if ($corezone->zone_name == 'N/A' && $corezone->entry_gate_name == 'N/A' && $corezone->is_open_in_monsoon == 1) {
    //                 }
    //                 if ($corezone->is_open_in_monsoon == 1) {
    //                     $total_core_closed_zone--;
    //                 }
    //             }
    //         }
    //         if (count($this->safariPark->corezones) == $total_core_closed_zone) {
    //             return false;
    //         }
    //         return true;
    //     }
    //     return true;
    // }               }
    //             }
    //         }
    //         if (count($this->safariPark->corezones) == $total_core_closed_zone) {
    //             return false;
    //         }
    //         return true;
    //     }
    //     return true;
    // }
}
