<?php

namespace App\Helpers;

class DateHelper{

    public function toUsaFormat($value) {
        $cpf = preg_replace('/\D/', '', $value);
        return $cpf;
    }

}