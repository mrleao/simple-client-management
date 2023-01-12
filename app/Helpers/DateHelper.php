<?php

namespace App\Helpers;

class DateHelper{

    public function toUsaFormat($value) {
        $newbirthDate = date('Y-m-d', strtotime($value));
        return $newbirthDate;
    }

}