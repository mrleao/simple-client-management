<?php

namespace App\Helpers;

class FormatHelper{

    public function toUsaFormat($value) {
        $newbirthDate = date('Y-m-d', strtotime($value));
        return $newbirthDate;
    }

    public function onlyNumbers($value) {
        $cpf = preg_replace('/\D/', '', $value);
        return $cpf;
    }
}