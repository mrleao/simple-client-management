<?php

namespace App\Helpers;

class CpfHelper{

    public function onlyNumbers($value) {
        $cpf = preg_replace('/\D/', '', $value);
        return $cpf;
    }

}