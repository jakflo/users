<?php


namespace App\Model;

use App\Model\name_validate;

class email_validate {
    public function validate($data) {
        $text_validator = new name_validate();
        $text_validated = $text_validator->validate($data, 45);
        if ($text_validated->stat) {return $text_validated;}
        if (filter_var($text_validated->tested_var, FILTER_VALIDATE_EMAIL) === false){
            $text_validated->err = "neplatný email";
            $text_validated->stat = true;
        }
        return $text_validated;
    }
}
