<?php

namespace common\traits;

use common\models\GeneralModel;


/**
 * Common Relations
 */
trait CommanRelationship
{
    /**
     * Status Label
     *
     * @return void
     */
    public function getStatuslabel()
    {
        $statuses = GeneralModel::statusoption();

        if (isset($statuses[$this->status])) {
            if ($this->status == 1) {
                return '<img src="/img/active.png" alt="" width="30" height="25">';
            } else if ($this->status == 2) {
                return '<img src="/img/suspend.png" alt="" width="30" height="25">';
            }
        }
        return $this->status;
    }

    public function getTestimoniallabel()
    {
        $return = '';
        if ($this->is_testimonial == 1) {
            $return = "<span class='btn btn-success btn-icon btn-sm'>Yes</span>";
        } else {
            $return = "<span class='btn btn-danger btn-icon btn-sm'>No</span>";
        }
        return $return;
    }
}
