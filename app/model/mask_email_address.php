<?php


namespace App\Model;


class mask_email_address {
    public function mask($email) {
        $email_splitted = explode("@", $email);
        $name = $email_splitted[0];
        $name_masked = substr($name, 0, 1) . "***" . substr($name, -1);
        $email_splitted[0] = $name_masked;
        return implode("@", $email_splitted);
    }
}
