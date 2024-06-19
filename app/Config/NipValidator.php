<?php

namespace Config;

class NipValidator
{
    private array $multiplication_array = [6, 5, 7, 2, 3, 4, 5, 6, 7];

    public function valid_nip(string $str, ?string &$error = null): bool{
        $validation_number = $str[9];

        $validation_result = 0;

        for($i = 0; $i < 9; $i++){
            $validation_result += $str[$i] * $this->multiplication_array[$i];
        }

        if($validation_result % 11 == $validation_number){
            return true;
        }

        $error = "Invalid NIP number";

        return false;
    }

    public function checkmax($str, string $field, array $data): bool{
        if($str < $data[$field]){
            return false;
        }

        return true;
    }
}