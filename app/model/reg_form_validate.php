<?php


namespace App\Model;

use app\entities\reg_form_ent;
use App\Model\name_validate;
use App\Model\email_validate;
use App\Model\role_validate;
use App\Model\pass_validate;

class reg_form_validate {
    
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }
    
    public function validate() {
        $cleared_data = new reg_form_ent;
        $errs = new reg_form_ent;
        $stat = false;
        
        
        $name_validator = new name_validate;
        $name_ent = $name_validator->validate($this->data->name, 25);
        $cleared_data->name = $name_ent->tested_var;
        $errs->name = $name_ent->err;
        $stat = $stat || $name_ent->stat;
        
        $email_validator = new email_validate;
        $email_ent = $email_validator->validate($this->data->email);
        $cleared_data->email = $email_ent->tested_var;
        $errs->email = $email_ent->err;
        $stat = $stat || $email_ent->stat;
        
        $role_validator = new role_validate;
        $role_ent = $role_validator->validate($this->data->role);
        $cleared_data->role = $role_ent->tested_var;
        $errs->role = $role_ent->err;
        $stat = $stat || $role_ent->stat;
        
        $pass_validator = new pass_validate;
        $pass_ent = $pass_validator->validate($this->data->password, $this->data->password_again);
        $cleared_data->password = $this->data->password;
        $cleared_data->password_again = $this->data->password_again;
        $errs->password = $pass_ent->err_pass1;
        $errs->password_again = $pass_ent->err_pass_conf;
        $stat = $stat || $pass_ent->stat;
        
        return array("data" => $cleared_data, "errs" => $errs, "stat" => $stat);
    }
}
